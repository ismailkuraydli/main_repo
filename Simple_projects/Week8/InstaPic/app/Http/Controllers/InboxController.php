<?php

namespace InstaPic\Http\Controllers;

use Illuminate\Http\Request;

use InstaPic\User;
use Auth;
class InboxController extends Controller
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
        $directMessages = $user->recievedDirectMessages;
        return view('inbox')->with('directMessages',$directMessages);
    }
}
