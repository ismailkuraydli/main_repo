<?php

namespace InstaPic\Http\Controllers;

use Illuminate\Http\Request;

use InstaPic\User;
use InstaPic\Post;
use InstaPic\Like;
use InstaPic\Comment;
use Auth;
class DashboardController extends Controller
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
        $following = $user->following->pluck('id')->toArray();
        if(empty($following)) {
            $posts = array();
            return view('dashboard')->with('posts',$posts);
        }
        $posts = Post::where('user_id',$following)->get();
        // foreach ($posts as $post) {
        //     dd($post->liked->where('id',Auth::id()) !== null);
        // }
        return view('dashboard',[
            'posts'=>$posts,
            'user'=>$user,
            ]);
    }
}
