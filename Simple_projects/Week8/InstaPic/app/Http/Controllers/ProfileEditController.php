<?php

namespace InstaPic\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

use InstaPic\User;
use InstaPic\Http\Requests\ProfileFormRequest;
use Auth;
class ProfileEditController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $user = User::find(Auth::id());
        return view('profile_edit')->with('user',$user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(ProfileFormRequest $request)
    {
        $user = User::find(Auth::id());
        if(Input::hasFile('avatar')) {
            $file = Input::file('avatar');
            $avatarPath = $file->store('public');
            $avatar = Storage::get($avatarPath);
            Storage::put($avatarPath,$avatar);
            $avatarUrl = Storage::url(basename($avatarPath));
            $avatarUrl = url($avatarUrl);
            dd($avatarUrl);
        }
        if(Input::hasFile('cover')) {
            $file = Input::file('cover');
            $coverPath = $file->store('public');
            $cover = Storage::get($coverPath);
            Storage::put($coverPath,$cover);
            $coverUrl = Storage::url(basename($coverPath));
            $coverUrl = url($coverUrl);
        }
        $user->update([
            'displayname'=> $request['displayname'],
            'avatar'=> $avatarUrl,
            'bio'=> $request['bio'],
            'cover'=> $coverUrl,
            'website'=> $request['website'],
            'gender'=> $request['gender'],
            'mobile'=> $request['mobile'],
        ]);
        return view('profile_edit')->with('user',$user);
    }
}
