<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $posts = BlogPost::with('category')->latest()->paginate(20);
        return view('admin.blog.index', compact('posts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:blog_posts',
            'content' => 'required|string',
            'category_id' => 'nullable|exists:blog_categories,id',
            'status' => 'required|in:draft,published',
        ]);

        BlogPost::create($request->all());
        return redirect()->back()->with('success', 'Post created!');
    }

    public function destroy(BlogPost $post)
    {
        $post->delete();
        return redirect()->back()->with('success', 'Post deleted!');
    }
}
