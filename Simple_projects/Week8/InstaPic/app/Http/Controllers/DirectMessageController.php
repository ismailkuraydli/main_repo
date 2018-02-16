<?php

namespace InstaPic\Http\Controllers;

use Illuminate\Http\Request;

use InstaPic\Directmessage;
use InstaPic\User;
use Auth;
class DirectMessageController extends Controller
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
    public function index($userId)
    {
        $user = User::findOrFail($userId);
        return view('direct_message')->with('user',$user);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function send(Request $request,$userId)
    {
        $content = $request['content'];

        Directmessage::create([
            'content'=> $content,
            'sender_id'=>Auth::id(),
            'reciever_id'=>$userId,
        ]);
        return redirect('/dashboard');
    }
}
