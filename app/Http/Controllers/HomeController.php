<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data_post = Post::orderByRaw('created_at DESC')->get();

        // rubah ke popular post 
        $latest_post = Post::orderByRaw('created_at DESC')->paginate(5);

        return view('post.index', compact('data_post', 'latest_post'));
    }
}
