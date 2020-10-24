<?php

namespace App\Http\Controllers;

use App\LikePost;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LikePostController extends Controller
{
    public function like($id)
    {
        LikePost::create([
            'post_id' => $id,
            'user_id' => Auth::id(),
        ]);

        return redirect()->back();
    }
}
