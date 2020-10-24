<?php

namespace App\Http\Controllers;

use App\User;
use App\Profile;
use App\Following;
use App\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class ProfileController extends Controller
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
        $data_userLogin = User::find(Auth::id());
        $my_post = Post::where('user_id', Auth::id())->get();
        $count_follower = Following::where('user_id_followed', Auth::id())->count();
        $count_following = Following::where('user_id_login', Auth::id())->count();
        $count_posted = Post::where('user_id', Auth::id())->count();
        return view('profile.index', compact('data_userLogin', 'my_post', 'count_follower', 'count_following', 'count_posted'));
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
        $is_followed = Following::where('user_id_login', Auth::id())->where('user_id_followed', $request->input('user_id_followed'))->first();
        // dd($is_followed);
        if (empty($is_followed)) {
            Following::create([
                'user_id_followed' => $request->input('user_id_followed'),
                'user_id_login' => Auth::id(),
            ]);
            return redirect()->route('post.index')->with('success', 'You Followed Successfully');
        } else {
            $is_followed->delete();
            return redirect()->route('post.index')->with('success', 'You Unfollowed Successfully');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $is_followed = Following::where('user_id_login', Auth::id())->where('user_id_followed', $id)->first();
        $data_user = User::find($id);
        $user_post = Post::where('user_id', $id)->get();
        $count_follower = Following::where('user_id_followed', $id)->count();
        $count_following = Following::where('user_id_login', $id)->count();
        $count_posted = Post::where('user_id', $id)->count();
        return view('profile.show', compact('data_user', 'user_post', 'count_follower', 'count_following', 'count_posted', 'is_followed'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $profile = Profile::where('user_id', Auth::id())->first();
        $data_profile = [
            'profile_fistName' => $request->profile_fistName,
            'profile_lastName' => $request->profile_lastName,
            'profile_phoneNumber' => $request->profile_phoneNumber,
            'profile_address' => $request->profile_address,
        ];

        $profile->update($data_profile);
        //Untuk Update File
        if ($request->hasFile('profile_image')) {
            $request->file('profile_image')->move('profileImage/', 'pImage-' . $request->file('profile_image')->getClientOriginalName());
            $profile->profile_image = 'pImage-' . $request->file('profile_image')->getClientOriginalName();
            $profile->save();
        }
        return redirect()->route('profile.index')->with("success", "Profile Edited Successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
