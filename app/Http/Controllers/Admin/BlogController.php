<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index()
    {
        $posts = BlogPost::with('category', 'author')->latest()->paginate(20);
        return view('admin.blog.index', compact('posts'));
    }

    public function create()
    {
        $categories = BlogCategory::all();
        $tags = BlogTag::all();
        return view('admin.blog.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:blog_posts,slug',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'blog_category_id' => 'nullable|exists:blog_categories,id',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'tags' => 'nullable|string',
        ]);

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('blog', 'public');
        }

        $validated['author_id'] = auth()->id();
        $validated['is_published'] = $request->boolean('is_published');

        if ($validated['is_published'] && !$validated['published_at']) {
            $validated['published_at'] = now();
        }

        $post = BlogPost::create($validated);

        // Sync tags
        if ($request->filled('tags')) {
            $tagIds = $this->syncTags($request->tags);
            $post->blogTags()->sync($tagIds);
        }

        return redirect()->route('admin.blog')->with('success', 'Blog post created successfully!');
    }

    public function show(BlogPost $post)
    {
        $post->load('category', 'author', 'comments.user', 'blogTags');
        return view('admin.blog.show', compact('post'));
    }

    public function edit(BlogPost $post)
    {
        $categories = BlogCategory::all();
        $tags = BlogTag::all();
        $post->load('blogTags');
        return view('admin.blog.edit', compact('post', 'categories', 'tags'));
    }

    public function update(Request $request, BlogPost $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:blog_posts,slug,' . $post->id,
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'blog_category_id' => 'nullable|exists:blog_categories,id',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'tags' => 'nullable|string',
        ]);

        if ($request->hasFile('featured_image')) {
            // Delete old image
            if ($post->featured_image) {
                Storage::disk('public')->delete($post->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')->store('blog', 'public');
        }

        $validated['is_published'] = $request->boolean('is_published');

        if ($validated['is_published'] && !$post->published_at && !$validated['published_at']) {
            $validated['published_at'] = now();
        }

        $post->update($validated);

        // Sync tags
        if ($request->filled('tags')) {
            $tagIds = $this->syncTags($request->tags);
            $post->blogTags()->sync($tagIds);
        } else {
            $post->blogTags()->detach();
        }

        return redirect()->route('admin.blog')->with('success', 'Blog post updated successfully!');
    }

    public function destroy(BlogPost $post)
    {
        if ($post->featured_image) {
            Storage::disk('public')->delete($post->featured_image);
        }
        $post->delete();
        return redirect()->back()->with('success', 'Blog post deleted!');
    }

    private function syncTags(string $tagsString): array
    {
        $tagNames = array_map('trim', explode(',', $tagsString));
        $tagIds = [];

        foreach ($tagNames as $name) {
            if (empty($name)) continue;
            $slug = Str::slug($name);
            $tag = BlogTag::firstOrCreate(
                ['slug' => $slug],
                ['name' => $name]
            );
            $tagIds[] = $tag->id;
        }

        return $tagIds;
    }
}
