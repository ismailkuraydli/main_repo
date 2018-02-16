<?php

namespace InstaPic\Http\Controllers;

use Illuminate\Http\Request;

use InstaPic\User;
use InstaPic\Post;
use Auth;
class ProfileViewController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function index() 
    {
        $user = User::find(Auth::id());
        $posts = Post::where('user_id',$user->id)->get();
        return view('profile_view')->with([
            'posts'=>$posts,
            'user'=>$user,
            ]);
    }
}
