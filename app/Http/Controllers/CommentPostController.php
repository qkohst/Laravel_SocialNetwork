<?php

namespace App\Http\Controllers;

use App\Post;
use App\CommentPost;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CommentPostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, Post $post)
    {
        CommentPost::create([
            'post_id' => $post->id,
            'user_id' => Auth::id(),
            'commentPost_content' => $request->commenntPost_content,
        ]);
        return redirect()->back()->with("success", "Your comment was posted successfully");
    }
}
