<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class BlogController extends Controller
{
    public function index()
    {
        // Only super admin can manage blogs
        if (\Auth::user()->type != 'super admin') {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
        
        $blogs = Blog::where('parent_id', 0)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('blog.index', compact('blogs'));
    }

    public function create()
    {
        // Only super admin can create blogs
        if (\Auth::user()->type != 'super admin') {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
        
        return view('blog.create');
    }

    public function store(Request $request)
    {
        // Only super admin can create blogs
        if (\Auth::user()->type != 'super admin') {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $validator = \Validator::make(
            $request->all(),
            [
                'title' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp',
                'content' => 'required',
                'description' => 'nullable|string|max:500',
                'meta_title' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string|max:500',
                'category' => 'nullable|string|max:100',
                'tags' => 'nullable|string',
                'author' => 'nullable|string|max:100',
            ]
        );
        
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first())->withInput();
        }

        $imageFileName = '';
        if ($request->hasFile('image')) {
            $imageFilenameWithExt = $request->file('image')->getClientOriginalName();
            $imageFilename = pathinfo($imageFilenameWithExt, PATHINFO_FILENAME);
            $imageExtension = $request->file('image')->getClientOriginalExtension();
            $imageFileName = $imageFilename . '_' . time() . '.' . $imageExtension;
            \Storage::disk('public')->putFileAs('upload/blog/image/', $request->file('image'), $imageFileName);
        }

        $baseSlug = Str::slug($request->title);
        $slug = $baseSlug;
        $counter = 1;

        while (Blog::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }

        $blog = new Blog();
        $blog->title = $request->title;
        $blog->slug = $slug;
        $blog->meta_title = $request->meta_title;
        $blog->meta_description = $request->meta_description;
        $blog->description = $request->description;
        $blog->content = $request->content;
        $blog->category = $request->category;
        $blog->tags = $request->tags;
        $blog->author = $request->author ?? \Auth::user()->name;
        $blog->enabled = $request->has('enabled') ? 1 : 0;
        $blog->image = $imageFileName;
        $blog->parent_id = 0; // Super admin blogs have parent_id = 0
        $blog->save();

        return redirect()->route('blog.index')->with('success', __('Blog successfully created.'));
    }

    public function edit(Blog $blog)
    {
        // Only super admin can edit blogs
        if (\Auth::user()->type != 'super admin') {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
        
        return view('blog.edit', compact('blog'));
    }
    public function update(Request $request, Blog $blog)
    {
        // Only super admin can edit blogs
        if (\Auth::user()->type != 'super admin') {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $rules = [
            'title' => 'required',
            'content' => 'required',
            'description' => 'nullable|string|max:500',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'category' => 'nullable|string|max:100',
            'tags' => 'nullable|string',
            'author' => 'nullable|string|max:100',
        ];

        if ($request->hasFile('image')) {
            $rules['image'] = 'image|mimes:jpeg,png,jpg,gif,webp';
        }

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->getMessageBag()->first())->withInput();
        }

        if ($request->hasFile('image')) {
            // Delete old image
            if (!empty($blog->image)) {
                if (\Storage::disk('public')->exists('upload/blog/image/' . $blog->image)) {
                    \Storage::disk('public')->delete('upload/blog/image/' . $blog->image);
                }
            }
            
            $imageFilenameWithExt = $request->file('image')->getClientOriginalName();
            $imageFilename = pathinfo($imageFilenameWithExt, PATHINFO_FILENAME);
            $imageExtension = $request->file('image')->getClientOriginalExtension();
            $imageFileName = $imageFilename . '_' . time() . '.' . $imageExtension;
            \Storage::disk('public')->putFileAs('upload/blog/image/', $request->file('image'), $imageFileName);
            $blog->image = $imageFileName;
        }

        if ($request->title !== $blog->title) {
            $baseSlug = Str::slug($request->title);
            $slug = $baseSlug;
            $counter = 1;

            while (Blog::where('slug', $slug)->where('id', '!=', $blog->id)->exists()) {
                $slug = $baseSlug . '-' . $counter++;
            }
            $blog->slug = $slug;
        }

        $blog->title = $request->title;
        $blog->meta_title = $request->meta_title;
        $blog->meta_description = $request->meta_description;
        $blog->description = $request->description;
        $blog->content = $request->content;
        $blog->category = $request->category;
        $blog->tags = $request->tags;
        $blog->author = $request->author ?? $blog->author;
        $blog->enabled = $request->has('enabled') ? 1 : 0;
        $blog->save();

        return redirect()->route('blog.index')->with('success', __('Blog successfully updated.'));
    }

    public function destroy(Blog $blog)
    {
        // Only super admin can delete blogs
        if (\Auth::user()->type != 'super admin') {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        // Delete Image
        if (!empty($blog->image)) {
            if (\Storage::disk('public')->exists('upload/blog/image/' . $blog->image)) {
                \Storage::disk('public')->delete('upload/blog/image/' . $blog->image);
            }
            // Also check legacy location
            $imagePath = storage_path('upload/blog/image/' . $blog->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        $blog->delete();

        return redirect()->route('blog.index')->with('success', __('Blog successfully deleted.'));
    }
}
