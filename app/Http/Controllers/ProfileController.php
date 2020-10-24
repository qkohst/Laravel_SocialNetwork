<?php

namespace App\Http\Controllers;

use App\User;
use App\Profile;
use App\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Null_;

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
        // create profile with null edentity 
        $id_profile = Profile::where('user_id', Auth::id())->first();
        if (empty($id_profile)) {
            $profile = new Profile();
            $profile->user_id     = Auth::id();
            $profile->save();
        }
        return view('profile.index', compact('data_userLogin', 'my_post'));
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
        //
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
            $request->file('profile_image')->move('profileImage/', 'S_Masuk-' . $request->file('profile_image')->getClientOriginalName());
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
