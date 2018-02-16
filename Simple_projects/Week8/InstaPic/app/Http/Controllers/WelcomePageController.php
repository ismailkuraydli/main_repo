<?php

namespace InstaPic\Http\Controllers;

use Illuminate\Http\Request;

use InstaPic\User;
use InstaPic\Post;
use InstaPic\Follow;
use Auth;
class WelcomePageController extends Controller
{
    public function index() 
    {
        // if(Auth::check()) {
        //     return view('dashboard');
        // }
        return view('welcome');
    }
}
