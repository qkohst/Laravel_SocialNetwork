<?php

namespace App\Http\Controllers;

use App\LikeCommentPost;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LikeCommentPostController extends Controller
{
    public function like($id)
    {
        $is_liked = LikeCommentPost::where('user_id', Auth::id())->where('commentPost_id', $id)->first();
        if (empty($is_liked)) {
            LikeCommentPost::create([
                'commentPost_id' => $id,
                'user_id' => Auth::id(),
            ]);
            return back()->with('success', 'You like a comment');
        } else {
            $is_liked->delete();
            return back()->with('success', 'You unlike a comment');
        }
    }
}
