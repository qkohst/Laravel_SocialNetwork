<?php

namespace App\Http\Controllers;

use App\LikePost;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LikePostController extends Controller
{
    public function like($id)
    {
        $is_liked = LikePost::where('user_id', Auth::id())->where('post_id', $id)->first();
        if (empty($is_liked)) {
            LikePost::create([
                'post_id' => $id,
                'user_id' => Auth::id(),
            ]);
            return redirect()->route('post.index')->with('success', 'You like a post');
        } else {
            $is_liked->delete();
            return redirect()->route('post.index')->with('success', 'You unlike a post');
        }
    }
}
