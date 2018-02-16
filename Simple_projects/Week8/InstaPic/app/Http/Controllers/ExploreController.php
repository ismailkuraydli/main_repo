<?php

namespace InstaPic\Http\Controllers;

use Illuminate\Http\Request;

use InstaPic\User;
use InstaPic\Post;
use InstaPic\Follow;
use Auth;

class ExploreController extends Controller
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
        $following = User::find(Auth::id())->following->pluck('id');
        $posts = Post::whereNotIn('user_id',$following)->get();
        return view('explore')->with('posts',$posts);
    }
}
