<?php

namespace App\Http\Controllers;

use App\Models\Advantage;
use App\Models\Amenity;
use App\Models\Blog;
use App\Models\FrontHomePage;
use App\Models\LeadFormField;
use App\Models\Notification;
use App\Models\Property;
use App\Models\PropertyUnit;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Crypt;

class FrontendController extends Controller
{
    public function themePage($code = null)
    {
        $user = User::where('code', $code)->firstOrFail();
        $settings = settingsById($user->id);
        $parent_id = $user->id;

        // Include both default (parent_id = 0) and user-specific amenities
        $allAmenities = Amenity::where(function($query) use ($user) {
            $query->where('parent_id', $user->id)
                  ->orWhere('parent_id', 0);
        })->orderBy('parent_id', 'asc')->orderBy('id', 'desc')->get();

        $listingTypes = Property::where('parent_id', $user->id)
            ->whereIn('listing_type', ['sell', 'rent'])
            ->select('listing_type')
            ->distinct()
            ->pluck('listing_type')
            ->toArray();

        $propertiesByType = Property::where('parent_id', $user->id)
            ->whereIn('listing_type', $listingTypes)
            ->get()
            ->groupBy('listing_type');

        // Get latest blogs for blog section
        $blogs = Blog::where('parent_id', $user->id)->latest()->take(3)->get();

        // Get subscriptions for pricing section
        $subscriptions = Subscription::orderBy('package_amount', 'asc')->get();

        return view('theme.index', compact('settings', 'parent_id', 'user', 'allAmenities', 'listingTypes', 'propertiesByType', 'blogs', 'subscriptions'));
    }


    public function searchLocation(Request $request, $code)
    {
        $locationSlug = $request->input('location');

        if (!$locationSlug) {
            return redirect()->back()->with('error', 'Location not selected.');
        }

        return redirect()->route('location.home', ['code' => $code]) . '?location=' . $locationSlug;
    }


    public function index()
    {
        if (!Auth::user()->can('manage front home page')) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
        $loginUser = Auth::user();
        $parentId = parentId();
        
        // Check if all sections exist (should be 11 sections: Section 0-10)
        $sectionsCount = FrontHomePage::where('parent_id', $parentId)->count();
        $expectedSections = ['Section 0', 'Section 1', 'Section 2', 'Section 3', 'Section 4', 'Section 5', 'Section 6', 'Section 7', 'Section 8', 'Section 9', 'Section 10'];
        
        if ($sectionsCount == 0) {
            // No sections exist, create all default sections
            FrontHomePageSection($parentId);
        } elseif ($sectionsCount < 11) {
            // Some sections are missing, check which ones and create them individually
            $existingSections = FrontHomePage::where('parent_id', $parentId)->pluck('section')->toArray();
            $missingSections = array_diff($expectedSections, $existingSections);
            
            if (!empty($missingSections)) {
                // Get section data from helper function logic
                $sectionDataMap = [
                    'Section 0' => ['title' => 'Banner', 'content_value' => '{"name":"Banner","section_enabled":"active","title":"Rentex","sub_title":"Property management refers to the administration, operation, and oversight of real estate properties on behalf of property owners. It involves various tasks such as marketing rental properties, finding tenants, collecting rent and ensuring legal compliance.","banner_image1":{},"banner_image1_path":""}'],
                    'Section 1' => ['title' => 'Offer', 'content_value' => '{"name":"Offer","section_enabled":"active","Sec1_title":"Property Highlights","Sec1_info":"Top reasons this property is a smart investment.","Sec1_box1_title":"Eco-Friendly Design","Sec1_box1_enabled":"active","Sec1_box1_info":"Energy-efficient appliances and solar panels","Sec1_box2_title":"Modern Amenities","Sec1_box2_enabled":"active","Sec1_box2_info":"Swimming pool, gym, and clubhouse included","Sec1_box3_title":"24\/7 Security","Sec1_box3_enabled":"active","Sec1_box3_info":"Round-the-clock surveillance and gated entry","Sec1_box4_title":"Low Maintenance Cost","Sec1_box4_enabled":"active","Sec1_box4_info":"Affordable society charges and upkeep","Sec1_box1_image_path":"","Sec1_box2_image_path":"","Sec1_box3_image_path":"","Sec1_box4_image_path":""}'],
                    'Section 2' => ['title' => 'OverView', 'content_value' => '{"name":"OverView","section_enabled":"active","Box1_title":"Total Property","Box1_number":"850","Box2_title":"Total Tenant","Box2_number":"1500","Box3_title":"Total Amenities","Box3_number":"500","Box4_title":"Years of Experience","Box4_number":"10"}'],
                    'Section 3' => ['title' => 'Category', 'content_value' => '{"name":"Amenity","section_enabled":"active","Sec3_title":"Available Amenities","Sec3_info":"Experience premium facilities that enhance your stay"}'],
                    'Section 4' => ['title' => 'AboutUs', 'content_value' => '{"name":"AboutUs","section_enabled":"active","Sec4_title":"A whole world of freelance talent at your fingertips","Sec4_Box_title":["Proof of quality","No cost until you hire","Safe and secure"],"Sec4_Box_subtitle":["Check any pro\'s work samples, client reviews, and identity verification.","Interview potential fits for your job, negotiate rates, and only pay for work you approve.","Focus on your work knowing we help protect your data and privacy. We\'re here with 24\/7 support if you need it."],"about_image":{},"about_image_path":""}'],
                    'Section 5' => ['title' => 'PopularService', 'content_value' => '{"name":"PopularService","section_enabled":"active","Sec5_title":"Find Your Perfect Property","Sec5_info":"Explore residential and commercial spaces that suit your needs."}'],
                    'Section 6' => ['title' => 'Banner2', 'content_value' => '{"name":"Banner2","section_enabled":"active","Sec6_title":"Simplify, Organize, Grow","Sec6_info":"Effortlessly manage every aspect of your property .Our all-in-one system turns complex tasks into simple wins ✓","sec6_btn_name":"Get Started","sec6_btn_link":"#","banner_image2":{},"banner_image2_path":""}'],
                    'Section 7' => ['title' => 'Testimonials', 'content_value' => '{"name":"Testimonials","section_enabled":"active","Sec7_title":"Testimonials","Sec7_info":"Interdum et malesuada fames ac ante ipsum","Sec7_box1_name":"","Sec7_box1_tag":"","Sec7_box1_Enabled":"active","Sec7_box1_review":"","Sec7_box2_name":"","Sec7_box2_tag":"","Sec7_box2_Enabled":"active","Sec7_box2_review":"","Sec7_box3_name":"","Sec7_box3_tag":"","Sec7_box3_Enabled":"active","Sec7_box3_review":"","Sec7_box4_name":"","Sec7_box4_tag":"","Sec7_box4_Enabled":"active","Sec7_box4_review":"","Sec7_box5_name":"","Sec7_box5_tag":"","Sec7_box5_Enabled":"active","Sec7_box5_review":"","Sec7_box6_image_path":"","Sec7_box7_image_path":"","Sec7_box8_image_path":""}'],
                    'Section 8' => ['title' => 'AboutUS - Footer', 'content_value' => '{"name":"AboutUS - Footer","section_enabled":"active","Sec8_info":"Property management refers to the administration, operation, and oversight of real estate properties on behalf of property owners. It involves various tasks such as marketing rental properties, finding tenants, collecting rent and ensuring legal compliance.","fb_link":"#","twitter_link":"#","insta_link":"#","linkedin_link":"#"}'],
                    'Section 9' => ['title' => 'Logo & Favicon', 'content_value' => '{"name":"Logo & Favicon","section_enabled":"active","logo_path":"","favicon_path":""}'],
                    'Section 10' => ['title' => 'Lead Settings', 'content_value' => '{"name":"Lead Settings","section_enabled":"active"}'],
                ];
                
                // Create missing sections
                foreach ($missingSections as $sectionName) {
                    if (isset($sectionDataMap[$sectionName])) {
                        $sectionInfo = $sectionDataMap[$sectionName];
                        $newSection = new FrontHomePage();
                        $newSection->title = $sectionInfo['title'];
                        $newSection->section = $sectionName;
                        $newSection->content = '';
                        $newSection->content_value = $sectionInfo['content_value'];
                        $newSection->enabled = 1;
                        $newSection->parent_id = $parentId;
                        $newSection->save();
                    }
                }
            }
        }
        
        // Check if Section 9 (Logo & Favicon) exists, if not create it
        $section9 = FrontHomePage::where('parent_id', $parentId)->where('section', 'Section 9')->first();
        $settings = settings();
        $appName = !empty($settings['app_name']) ? $settings['app_name'] : env('APP_NAME', 'Rentex');
        
        if (!$section9) {
            $section9 = new FrontHomePage();
            $section9->title = 'Logo & Favicon';
            $section9->section = 'Section 9';
            $section9->content = '';
            $section9->content_value = json_encode([
                'name' => 'Logo & Favicon', 
                'section_enabled' => 'active', 
                'application_name' => $appName,
                'logo_path' => '', 
                'light_logo_path' => '',
                'favicon_path' => ''
            ]);
            $section9->enabled = 1;
            $section9->parent_id = $parentId;
            $section9->save();
        } else {
            // Update existing Section 9 to include application_name and light_logo_path if missing
            $section9_content = !empty($section9->content_value) ? json_decode($section9->content_value, true) : [];
            $needsUpdate = false;
            
            if (empty($section9_content['application_name'])) {
                $section9_content['application_name'] = $appName;
                $needsUpdate = true;
            }
            
            if (!isset($section9_content['light_logo_path'])) {
                $section9_content['light_logo_path'] = '';
                $needsUpdate = true;
            }
            
            if ($needsUpdate) {
                $section9->content_value = json_encode($section9_content);
                $section9->save();
            }
        }
        
        // Check if Section 10 (Lead Settings) exists, if not create it
        $section10 = FrontHomePage::where('parent_id', $parentId)->where('section', 'Section 10')->first();
        if (!$section10) {
            $section10 = new FrontHomePage();
            $section10->title = 'Lead Settings';
            $section10->section = 'Section 10';
            $section10->content = '';
            $section10->content_value = json_encode(['name' => 'Lead Settings', 'section_enabled' => 'active']);
            $section10->enabled = 1;
            $section10->parent_id = $parentId;
            $section10->save();
        }
        
        // Check if default lead form fields exist, if not create them
        $defaultFieldsCount = LeadFormField::where('parent_id', $parentId)->where('is_default', true)->count();
        if ($defaultFieldsCount == 0) {
            $defaultFields = [
                [
                    'field_name' => 'name',
                    'field_label' => 'Name',
                    'field_type' => 'input',
                    'field_options' => null,
                    'is_required' => true,
                    'is_default' => true,
                    'sort_order' => 1,
                    'parent_id' => $parentId,
                ],
                [
                    'field_name' => 'email',
                    'field_label' => 'Email',
                    'field_type' => 'input',
                    'field_options' => null,
                    'is_required' => true,
                    'is_default' => true,
                    'sort_order' => 2,
                    'parent_id' => $parentId,
                ],
                [
                    'field_name' => 'phone',
                    'field_label' => 'Phone',
                    'field_type' => 'input',
                    'field_options' => null,
                    'is_required' => true,
                    'is_default' => true,
                    'sort_order' => 3,
                    'parent_id' => $parentId,
                ],
            ];
            
            foreach ($defaultFields as $fieldData) {
                LeadFormField::create($fieldData);
            }
        }
        
        // Get all sections and order them so Section 9 and 10 appear first
        $frontHomePage = FrontHomePage::where('parent_id', '=', $parentId)
            ->orderByRaw("CASE 
                WHEN section = 'Section 9' THEN 1 
                WHEN section = 'Section 10' THEN 2 
                ELSE 3 
            END")
            ->orderBy('section', 'asc')
            ->get();
            
        $leadFormFields = LeadFormField::where('parent_id', $parentId)
            ->orderBy('is_default', 'desc')
            ->orderBy('sort_order', 'asc')
            ->get();

        return view('front-home.index', compact('loginUser', 'frontHomePage', 'leadFormFields'));
    }

    public function update(Request $request, FrontHomePage $homePage, $id)
    {

        if (!Auth::user()->can('edit front home page')) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $homePage = FrontHomePage::find($id);
        $old_content_value = '';
        if (!empty($request->content_value)) {
            $old_content_value = json_decode($homePage->content_value, true);
        }
        $content_value = $request->content_value;

        /* section 0 */
        if ($request->tab == 'profile_tab_1') {
            if (!empty($request->content_value['banner_image1'])) {
                $banner_image1 = $request->content_value['banner_image1'];
                $filenameWithExt = $banner_image1->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $banner_image1->getClientOriginalExtension();
                $fileNameToStore = $filename . '_banner_image1_' . date('Ymdhisa') . '.' . $extension;

                // Use Storage::disk('public') to save to storage/app/public for web accessibility
                \Storage::disk('public')->putFileAs('upload/fronthomepage/', $banner_image1, $fileNameToStore);
                $content_value['banner_image1_path'] = 'upload/fronthomepage/' . $fileNameToStore;
            } else {
                $content_value['banner_image1_path'] = !empty($old_content_value['banner_image1_path']) ? $old_content_value['banner_image1_path'] : '';
            }

            // Handle background image upload
            if (!empty($request->content_value['bg_image'])) {
                $bg_image = $request->content_value['bg_image'];
                $filenameWithExt = $bg_image->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $bg_image->getClientOriginalExtension();
                $fileNameToStore = $filename . '_bg_image_' . date('Ymdhisa') . '.' . $extension;

                // Use Storage::disk('public') to save to storage/app/public for web accessibility
                \Storage::disk('public')->putFileAs('upload/fronthomepage/', $bg_image, $fileNameToStore);
                $content_value['bg_image_path'] = 'upload/fronthomepage/' . $fileNameToStore;
            } else {
                $content_value['bg_image_path'] = !empty($old_content_value['bg_image_path']) ? $old_content_value['bg_image_path'] : '';
            }
        }

        /* section 1 */
        if ($request->tab == 'profile_tab_2') {
            for ($is4 = 1; $is4 <= 4; $is4++) {
                if (!empty($request->content_value['Sec1_box' . $is4 . '_image'])) {
                    $box_image_path = $request->content_value['Sec1_box' . $is4 . '_image'];
                    $filenameWithExt = $box_image_path->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    $extension = $box_image_path->getClientOriginalExtension();
                    $fileNameToStore = $filename . '_Section_4_image_' . $is4 . date('Ymdhisa') . '.' . $extension;

                    // Use Storage::disk('public') to save to storage/app/public for web accessibility
                    \Storage::disk('public')->putFileAs('upload/fronthomepage/', $box_image_path, $fileNameToStore);
                    $content_value['Sec1_box' . $is4 . '_image_path'] = 'upload/fronthomepage/' . $fileNameToStore;
                } else {
                    $content_value['Sec1_box' . $is4 . '_image_path'] = !empty($old_content_value['Sec1_box' . $is4 . '_image_path']) ? $old_content_value['Sec1_box' . $is4 . '_image_path'] : '';
                }
            }
        }

        /* section 2 */
        // if ($request->tab == 'profile_tab_3') {
        //     for ($i = 1; $i <= 4; $i++) {
        //         if (!empty($request->content_value['box' . $i . '_number_image'])) {
        //             $box_image_path = $request->content_value['box' . $i . '_number_image'];
        //             $filenameWithExt = $box_image_path->getClientOriginalName();
        //             $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        //             $extension = $box_image_path->getClientOriginalExtension();
        //             $fileNameToStore = $filename . '_box_image_path_' . $i . date('Ymdhisa') . '.' . $extension;

        //             $dir = storage_path('upload/fronthomepage/');
        //             if (!file_exists($dir)) {
        //                 mkdir($dir, 0777, true);
        //             }

        //             $box_image_path->storeAs('upload/fronthomepage/', $fileNameToStore);
        //             $content_value['box_image_' . $i . '_path'] = 'upload/fronthomepage/' . $fileNameToStore;
        //         } else {
        //             $content_value['box_image_' . $i . '_path'] = !empty($old_content_value['box_image_' . $i . '_path']) ? $old_content_value['box_image_' . $i . '_path'] : '';
        //         }
        //     }
        // }


        /* section 4 */
        if ($request->tab == 'profile_tab_5') {
            if (!empty($request->content_value['about_image'])) {
                $about_image = $request->content_value['about_image'];
                $filenameWithExt = $about_image->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $about_image->getClientOriginalExtension();
                $fileNameToStore = $filename . '_about_image_' . date('Ymdhisa') . '.' . $extension;

                // Use Storage::disk('public') to save to storage/app/public for web accessibility
                \Storage::disk('public')->putFileAs('upload/fronthomepage/', $about_image, $fileNameToStore);
                $content_value['about_image_path'] = 'upload/fronthomepage/' . $fileNameToStore;
            } else {
                $content_value['about_image_path'] = !empty($old_content_value['about_image_path']) ? $old_content_value['about_image_path'] : '';
            }
        }


        /* section 6 */
        if ($request->tab == 'profile_tab_7') {
            if (!empty($request->content_value['banner_image2'])) {
                $banner_image2 = $request->content_value['banner_image2'];
                $filenameWithExt = $banner_image2->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $banner_image2->getClientOriginalExtension();
                $fileNameToStore = $filename . '_banner_image2_' . date('Ymdhisa') . '.' . $extension;

                // Use Storage::disk('public') to save to storage/app/public for web accessibility
                \Storage::disk('public')->putFileAs('upload/fronthomepage/', $banner_image2, $fileNameToStore);
                $content_value['banner_image2_path'] = 'upload/fronthomepage/' . $fileNameToStore;
            } else {
                $content_value['banner_image2_path'] = !empty($old_content_value['banner_image2_path']) ? $old_content_value['banner_image2_path'] : '';
            }
        }

        /* section 7 */
        if ($request->tab == 'profile_tab_8') {
            for ($is7 = 1; $is7 <= 8; $is7++) {
                if (!empty($request->content_value['Sec7_box' . $is7 . '_image'])) {
                    $box_image_path = $request->content_value['Sec7_box' . $is7 . '_image'];
                    $filenameWithExt = $box_image_path->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    $extension = $box_image_path->getClientOriginalExtension();
                    $fileNameToStore = $filename . '_Section_7_image_' . $is7 . date('Ymdhisa') . '.' . $extension;

                    // Use Storage::disk('public') to save to storage/app/public for web accessibility
                    \Storage::disk('public')->putFileAs('upload/fronthomepage/', $box_image_path, $fileNameToStore);
                    $content_value['Sec7_box' . $is7 . '_image_path'] = 'upload/fronthomepage/' . $fileNameToStore;
                } else {
                    $content_value['Sec7_box' . $is7 . '_image_path'] = !empty($old_content_value['Sec7_box' . $is7 . '_image_path']) ? $old_content_value['Sec7_box' . $is7 . '_image_path'] : '';
                }
            }
        }

        /* section 9 - Logo & Favicon */
        // Check if this is Section 9 by finding the section record
        $section9Record = FrontHomePage::where('parent_id', parentId())->where('section', 'Section 9')->first();
        if ($section9Record && $request->tab == 'profile_tab_' . $section9Record->id) {
            // Save Application Name
            if (!empty($request->content_value['application_name'])) {
                $appName = $request->content_value['application_name'];
                $content_value['application_name'] = $appName;
                
                // Also save to settings table
                \DB::insert(
                    'INSERT INTO settings (`value`, `name`, `parent_id`) VALUES (?, ?, ?)
                 ON DUPLICATE KEY UPDATE `value` = VALUES(`value`)',
                    [$appName, 'app_name', parentId()]
                );
            } else {
                $content_value['application_name'] = !empty($old_content_value['application_name']) ? $old_content_value['application_name'] : '';
            }
            
            if (!empty($request->content_value['logo'])) {
                $logo = $request->content_value['logo'];
                $filenameWithExt = $logo->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $logo->getClientOriginalExtension();
                $fileNameToStore = $filename . '_logo_' . date('Ymdhisa') . '.' . $extension;

                \Storage::disk('public')->putFileAs('upload/logo/', $logo, $fileNameToStore);
                $content_value['logo_path'] = 'upload/logo/' . $fileNameToStore;
            } else {
                $content_value['logo_path'] = !empty($old_content_value['logo_path']) ? $old_content_value['logo_path'] : '';
            }

            if (!empty($request->content_value['light_logo'])) {
                $lightLogo = $request->content_value['light_logo'];
                $filenameWithExt = $lightLogo->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $lightLogo->getClientOriginalExtension();
                $fileNameToStore = $filename . '_light_logo_' . date('Ymdhisa') . '.' . $extension;

                \Storage::disk('public')->putFileAs('upload/logo/', $lightLogo, $fileNameToStore);
                $content_value['light_logo_path'] = 'upload/logo/' . $fileNameToStore;
            } else {
                $content_value['light_logo_path'] = !empty($old_content_value['light_logo_path']) ? $old_content_value['light_logo_path'] : '';
            }

            if (!empty($request->content_value['favicon'])) {
                $favicon = $request->content_value['favicon'];
                $filenameWithExt = $favicon->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $favicon->getClientOriginalExtension();
                $fileNameToStore = $filename . '_favicon_' . date('Ymdhisa') . '.' . $extension;

                \Storage::disk('public')->putFileAs('upload/favicon/', $favicon, $fileNameToStore);
                $content_value['favicon_path'] = 'upload/favicon/' . $fileNameToStore;
            } else {
                $content_value['favicon_path'] = !empty($old_content_value['favicon_path']) ? $old_content_value['favicon_path'] : '';
            }
        }

        $homePage->content_value = json_encode($content_value);
        $homePage->save();
        return redirect()->back()->with('tab', $request->tab)->with('success', __('Home Page Content Updated Successfully.'));
    }


    public function blogPage(Request $request, $code)
    {
        $user = User::where('code', $code)->first();
        $settings = settingsById($user->id);
        $blogs = Blog::where('parent_id', $user->id)->latest()->paginate(4);
        if ($request->ajax()) {
            return view('theme.blogbox', compact('blogs', 'settings', 'user'))->render();
        }

        return view('theme.blog', compact('blogs', 'settings', 'user'));
    }

    // public function blogDetailPage($code, $blog)
    // {
    //     $user = User::where('code', $code)->first();
    //     $settings = settingsById($user->id);
    //     $blog = Blog::find($blog);
    //     return view('theme.blog-detail', compact('blog', 'settings', 'user'));
    // }

    public function blogDetailPage($code, $slug)
    {
        $user = User::where('code', $code)->firstOrFail();
        $settings = settingsById($user->id);
        // Get super admin blog (parent_id = 0) that is enabled
        $blog = Blog::where('parent_id', 0)
            ->where('enabled', 1)
            ->where('slug', $slug)
            ->firstOrFail();
        
        // Increment views
        $blog->increment('views');

        // Get related blogs (same category, excluding current)
        $relatedBlogs = Blog::where('parent_id', 0)
            ->where('enabled', 1)
            ->where('id', '!=', $blog->id)
            ->where(function($query) use ($blog) {
                if ($blog->category) {
                    $query->where('category', $blog->category);
                }
            })
            ->latest()
            ->take(3)
            ->get();

        // If not enough related blogs, get any recent blogs
        if ($relatedBlogs->count() < 3) {
            $additionalBlogs = Blog::where('parent_id', 0)
                ->where('enabled', 1)
                ->where('id', '!=', $blog->id)
                ->whereNotIn('id', $relatedBlogs->pluck('id'))
                ->latest()
                ->take(3 - $relatedBlogs->count())
                ->get();
            $relatedBlogs = $relatedBlogs->merge($additionalBlogs);
        }

        return view('theme.blog-detail', compact('blog', 'settings', 'user', 'relatedBlogs'));
    }




    public function propertyPage(Request $request, $code)
    {
        $user = User::where('code', $code)->firstOrFail();
        $settings = settingsById($user->id);

        $listingTypes = Property::where('parent_id', $user->id)
            ->whereIn('listing_type', ['sell', 'rent'])
            ->select('listing_type')
            ->distinct()
            ->pluck('listing_type')
            ->toArray();

        $propertyType = Property::where('parent_id', $user->id)
            ->whereIn('listing_type', $listingTypes)
            ->get()
            ->groupBy('listing_type');

        $query = Property::where('parent_id', $user->id);

        // Filter by listing_type if provided
        if ($request->filled('listing_type') && $request->listing_type !== 'all') {
            $query->where('listing_type', $request->listing_type);
        }

        $properties = $query->latest()->paginate(12);

        $noPropertiesMessage = $properties->isEmpty()
            ? 'No properties available with the selected filters.'
            : '';


        $countries = Property::where('parent_id', $user->id)
            ->whereNotNull('country')
            ->where('country', '!=', '')
            ->select('country')
            ->distinct()
            ->orderBy('country')
            ->pluck('country');

        $states = Property::where('parent_id', $user->id)
            ->whereNotNull('state')
            ->where('state', '!=', '')
            ->select('state')
            ->distinct()
            ->orderBy('state')
            ->pluck('state');

        $cities = Property::where('parent_id', $user->id)
            ->whereNotNull('city')
            ->where('city', '!=', '')
            ->select('city')
            ->distinct()
            ->orderBy('city')
            ->pluck('city');


        if ($request->ajax()) {
            return view('theme.propertybox', compact('properties', 'user', 'noPropertiesMessage', 'settings', 'propertyType', 'countries', 'states', 'cities', 'listingTypes'))->render();
        }

        return view('theme.property', compact('properties', 'settings', 'user', 'propertyType', 'noPropertiesMessage', 'countries', 'states', 'cities', 'listingTypes'));
    }




    public function detailPage($code, $id)
    {

        $ids = Crypt::decrypt($id);
        $property = Property::where('id', $ids)->first();
        $units = PropertyUnit::where('property_id', $property->id)->orderBy('id', 'desc')->get();

        $user = User::where('code', $code)->firstOrFail();
        $settings = settingsById($user->id);


        $selectedAmenities = collect();
        if (!empty($property->amenities_id)) {
            $ids = array_filter(explode(',', $property->amenities_id));
            $selectedAmenities = Amenity::whereIn('id', $ids)->get();
        }

        $selectedAdvantages = collect();
        if (!empty($property->advantage_id)) {
            $ids = array_filter(explode(',', $property->advantage_id));
            $selectedAdvantages = Advantage::whereIn('id', $ids)->get();
        }


        return view('theme.detail', compact('code', 'property', 'user', 'settings', 'selectedAmenities', 'selectedAdvantages', 'units'));
    }


    public function contactPage(Request $request, $code)
    {
        $user = User::where('code', $code)->first();
        $settings = settingsById($user->id);
        
        // Get property_id from query parameter if exists
        $propertyId = null;
        $property = null;
        if ($request->has('property_id')) {
            try {
                $propertyId = Crypt::decrypt($request->property_id);
                $property = Property::where('id', $propertyId)->where('parent_id', $user->id)->first();
            } catch (\Exception $e) {
                // Invalid property ID, ignore it
            }
        }
        
        // Get Lead Form Fields for this owner
        $leadFormFields = \App\Models\LeadFormField::where('parent_id', $user->id)
            ->orderBy('is_default', 'desc')
            ->orderBy('sort_order', 'asc')
            ->get();
        
        return view('theme.contact', compact('settings', 'user', 'property', 'propertyId', 'leadFormFields'));
    }

    public function getStates(Request $request, $code)
    {
        try {
            \Log::info('getStates called', [
                'code' => $code,
                'country' => $request->input('country'),
                'all_params' => $request->all()
            ]);
            
            $user = User::where('code', $code)->firstOrFail();
            
            $query = Property::where('parent_id', $user->id);
            
            if ($request->filled('country')) {
                $query->where('country', $request->country);
                \Log::info('Filtering by country: ' . $request->country);
            }
            
            $states = $query
                ->whereNotNull('state')
                ->where('state', '!=', '')
            ->distinct()
                ->orderBy('state')
                ->pluck('state')
                ->filter(function($value) {
                    return !empty($value) && trim($value) !== '';
                })
                ->values();

            $statesArray = $states->toArray();
            \Log::info('States found', [
                'count' => count($statesArray),
                'states' => $statesArray
            ]);

            return response()->json($statesArray);
        } catch (\Exception $e) {
            \Log::error('Error in getStates: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getCities(Request $request, $code)
    {
        try {
            \Log::info('getCities called', [
                'code' => $code,
                'state' => $request->input('state'),
                'all_params' => $request->all()
            ]);
            
            $user = User::where('code', $code)->firstOrFail();
            
            $query = Property::where('parent_id', $user->id);
            
            if ($request->filled('state')) {
                $query->where('state', $request->state);
                \Log::info('Filtering by state: ' . $request->state);
            }
            
            $cities = $query
                ->whereNotNull('city')
                ->where('city', '!=', '')
            ->distinct()
                ->orderBy('city')
                ->pluck('city')
                ->filter(function($value) {
                    return !empty($value) && trim($value) !== '';
                })
                ->values();

            $citiesArray = $cities->toArray();
            \Log::info('Cities found', [
                'count' => count($citiesArray),
                'cities' => $citiesArray
            ]);

            return response()->json($citiesArray);
        } catch (\Exception $e) {
            \Log::error('Error in getCities: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function search(Request $request, $code)
    {
        $user = User::where('code', $code)->firstOrFail();
        $settings = settingsById($user->id);

        $listingTypes = Property::where('parent_id', $user->id)
            ->whereIn('listing_type', ['sell', 'rent'])
            ->select('listing_type')
            ->distinct()
            ->pluck('listing_type')
            ->toArray();

        $query = Property::where('parent_id', $user->id);

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('country')) {
            $query->where('country', $request->country);
        }

        if ($request->filled('state')) {
            $query->where('state', $request->state);
        }

        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        // Filter by listing_type if provided
        if ($request->filled('listing_type') && $request->listing_type !== 'all') {
            $query->where('listing_type', $request->listing_type);
        }

        $properties = $query->paginate(12);

        $noPropertiesMessage = $properties->isEmpty()
            ? 'No properties available with the selected filters.'
            : '';

        // Load countries, states, and cities for the filter dropdowns
        $countries = Property::where('parent_id', $user->id)
            ->whereNotNull('country')
            ->where('country', '!=', '')
            ->select('country')
            ->distinct()
            ->orderBy('country')
            ->pluck('country');

        $states = Property::where('parent_id', $user->id)
            ->whereNotNull('state')
            ->where('state', '!=', '')
            ->select('state')
            ->distinct()
            ->orderBy('state')
            ->pluck('state');

        $cities = Property::where('parent_id', $user->id)
            ->whereNotNull('city')
            ->where('city', '!=', '')
            ->select('city')
            ->distinct()
            ->orderBy('city')
            ->pluck('city');

        if ($request->ajax() || $request->has('ajax')) {
            return view('theme.propertybox', [
                'properties' => $properties,
                'settings' => $settings,
                'user' => $user,
                 'noPropertiesMessage' => $noPropertiesMessage,
                 'listingTypes' => $listingTypes,
            ])->render();
        }

        return view('theme.property', compact('user', 'properties', 'settings', 'countries', 'states', 'cities', 'listingTypes', 'noPropertiesMessage'));
    }

    public function storeLeadField(Request $request)
    {
        if (!Auth::user()->can('edit front home page')) {
            return response()->json(['status' => 'error', 'msg' => __('Permission Denied.')], 403);
        }

        $validator = \Validator::make($request->all(), [
            'field_label' => 'required|string|max:255',
            'field_type' => 'required|in:text,number,docs',
            'is_required' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'msg' => $validator->messages()->first()], 422);
        }

        $maxSortOrder = LeadFormField::where('parent_id', parentId())->max('sort_order') ?? 0;

        $field = new LeadFormField();
        $field->field_name = strtolower(str_replace(' ', '_', $request->field_label));
        $field->field_label = $request->field_label;
        // Map frontend types to database types
        $fieldTypeMap = [
            'text' => 'input',
            'number' => 'input',
            'docs' => 'doc'
        ];
        $field->field_type = $fieldTypeMap[$request->field_type] ?? 'input';
        // Store the original type for display purposes
        $field->field_options = json_encode(['original_type' => $request->field_type]);
        $field->is_required = $request->is_required ?? false;
        $field->is_default = false;
        $field->sort_order = $maxSortOrder + 1;
        $field->parent_id = parentId();
        $field->save();

        return response()->json(['status' => 'success', 'msg' => __('Field created successfully.'), 'field' => $field]);
    }

    public function updateLeadField(Request $request, $id)
    {
        if (!Auth::user()->can('edit front home page')) {
            return response()->json(['status' => 'error', 'msg' => __('Permission Denied.')], 403);
        }

        $field = LeadFormField::where('id', $id)->where('parent_id', parentId())->first();
        if (!$field) {
            return response()->json(['status' => 'error', 'msg' => __('Field not found.')], 404);
        }

        if ($field->is_default) {
            return response()->json(['status' => 'error', 'msg' => __('Default fields cannot be edited.')], 403);
        }

        $validator = \Validator::make($request->all(), [
            'field_label' => 'required|string|max:255',
            'field_type' => 'required|in:text,number,docs',
            'is_required' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'msg' => $validator->messages()->first()], 422);
        }

        // Map frontend types to database types
        $fieldTypeMap = [
            'text' => 'input',
            'number' => 'input',
            'docs' => 'doc'
        ];
        
        $field->field_label = $request->field_label;
        $field->field_type = $fieldTypeMap[$request->field_type] ?? 'input';
        // Store the original type for display purposes
        $field->field_options = json_encode(['original_type' => $request->field_type]);
        $field->is_required = $request->is_required ?? false;
        $field->save();

        return response()->json(['status' => 'success', 'msg' => __('Field updated successfully.'), 'field' => $field]);
    }

    public function destroyLeadField($id)
    {
        if (!Auth::user()->can('edit front home page')) {
            return response()->json(['status' => 'error', 'msg' => __('Permission Denied.')], 403);
        }

        $field = LeadFormField::where('id', $id)->where('parent_id', parentId())->first();
        if (!$field) {
            return response()->json(['status' => 'error', 'msg' => __('Field not found.')], 404);
        }

        if ($field->is_default) {
            return response()->json(['status' => 'error', 'msg' => __('Default fields cannot be deleted.')], 403);
        }

        $field->delete();
        return response()->json(['status' => 'success', 'msg' => __('Field deleted successfully.')]);
    }

    public function reorderLeadFields(Request $request)
    {
        if (!Auth::user()->can('edit front home page')) {
            return response()->json(['status' => 'error', 'msg' => __('Permission Denied.')], 403);
        }

        $order = $request->input('order', []);
        foreach ($order as $index => $fieldId) {
            LeadFormField::where('id', $fieldId)
                ->where('parent_id', parentId())
                ->update(['sort_order' => $index + 1]);
        }

        return response()->json(['status' => 'success', 'msg' => __('Fields reordered successfully.')]);
    }
}
