<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Message;
use App\User;
use Auth;

class ChatRoomController extends Controller
{
    /**
     * Starts chat page and get all messages from database
     */
    public function index()
    {
        if(!Auth::check()) {
            return view('auth.login');
        }
        $user = User::find(Auth::id());
        $messages = new Message;
        $messages = $messages->all();
        return view('chatroom',['messages'=>$messages,'user'=>$user]);
    }
    /**
     * Receves request and saves in database
     */
    public function store(Request $request)
    {
        dd($request);
        return redirect('home');
    }

    public function create(Request $request) {
        $messages = new Message;
        $messages->create([
            'content' => $request->text,
            'user_id' => Auth::id(),
        ]);
    }
}
