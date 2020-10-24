<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data_post = Post::orderByRaw('created_at DESC')->get();

        // rubah ke popular post 
        $latest_post = Post::orderByRaw('created_at DESC')->paginate(5);

        return view('post.index', compact('data_post', 'latest_post'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post = new Post();
        $post->post_content   = $request->input('post_content');
        $image                   = $request->file('postImageName');
        $imageName   = 'pImage-' . $image->getClientOriginalName();
        $image->move('postImage/', $imageName);
        $post->post_image  = $imageName;
        $post->user_id     = Auth::id();
        $post->save();
        return redirect()->route('post.index')->with("success", "Posted Successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data_post = Post::find($id);
        return view('post.edit', compact('data_post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = Post::findorfail($id);

        $data_post = [
            'post_content' => $request->post_content,
        ];

        $post->update($data_post);

        return redirect()->route('post.index')->with('success', 'Edited Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        $post->delete();
        return redirect()->route('post.index')->with('success', 'Removed Successfully');
    }
}
