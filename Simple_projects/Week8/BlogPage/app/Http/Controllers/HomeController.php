<?php

namespace OpenBook\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use OpenBook\Blog;
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogs = \OpenBook\Blog::where('user_id',Auth::user()->id)->get();
        return view('home')->with('blogs',$blogs);
    }
}
