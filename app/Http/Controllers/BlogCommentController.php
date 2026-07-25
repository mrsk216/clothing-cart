<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\BlogComment;
use Illuminate\Http\Request;

class BlogCommentController extends Controller
{
    public function store(Request $request, BlogPost $post)
    {
        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        BlogComment::create([
            'blog_post_id' => $post->id,
            'user_id' => auth()->id(),
            'comment' => $request->comment,
            'is_approved' => false,
        ]);

        return back()->with('success', 'Your comment has been submitted and is pending approval.');
    }
}
