<?php

namespace App\Http\Controllers;

use App\LikeCommentPost;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LikeCommentPostController extends Controller
{
    public function like($id)
    {
        LikeCommentPost::create([
            'commentPost_id' => $id,
            'user_id' => Auth::id(),
        ]);

        return redirect()->back();
    }
}
