<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogComment;
use Illuminate\Http\Request;

class BlogCommentController extends Controller
{
    public function index()
    {
        $comments = BlogComment::with('post', 'user')->latest()->paginate(20);
        return view('admin.blog.comments.index', compact('comments'));
    }

    public function approve(BlogComment $comment)
    {
        $comment->update(['is_approved' => true]);
        return redirect()->back()->with('success', 'Comment approved!');
    }

    public function destroy(BlogComment $comment)
    {
        $comment->delete();
        return redirect()->back()->with('success', 'Comment deleted!');
    }
}
