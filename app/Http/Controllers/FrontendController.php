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

        return view('theme.index', compact('settings', 'parent_id', 'user', 'allAmenities', 'listingTypes', 'propertiesByType'));
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
        $blog = Blog::where('slug', $slug)->firstOrFail();

        return view('theme.blog-detail', compact('blog', 'settings', 'user'));
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
        
        return view('theme.contact', compact('settings', 'user', 'property', 'propertyId'));
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
            'field_type' => 'required|in:input,doc,checkbox,yes_no,select',
            'field_options' => 'required_if:field_type,select|array',
            'is_required' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'msg' => $validator->messages()->first()], 422);
        }

        $maxSortOrder = LeadFormField::where('parent_id', parentId())->max('sort_order') ?? 0;

        $field = new LeadFormField();
        $field->field_name = strtolower(str_replace(' ', '_', $request->field_label));
        $field->field_label = $request->field_label;
        $field->field_type = $request->field_type;
        $field->field_options = $request->field_type == 'select' ? json_encode($request->field_options) : null;
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
            'field_type' => 'required|in:input,doc,checkbox,yes_no,select',
            'field_options' => 'required_if:field_type,select|array',
            'is_required' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'msg' => $validator->messages()->first()], 422);
        }

        $field->field_label = $request->field_label;
        $field->field_type = $request->field_type;
        $field->field_options = $request->field_type == 'select' ? json_encode($request->field_options) : null;
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
