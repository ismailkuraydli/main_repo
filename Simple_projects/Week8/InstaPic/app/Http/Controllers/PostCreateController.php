<?php

namespace InstaPic\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

use InstaPic\Post;
use InstaPic\Http\Requests\PostFormRequest;
use Auth;
class PostCreateController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('post_create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostFormRequest $request)
    {
        $userId = Auth::id();
        $caption = $request['caption'];
        if(Input::hasFile('image')) {
            $file = Input::file('image');
            $imagePath = $file->store('public');
            $image = Storage::get($imagePath);
            Storage::put($imagePath,$image);
            $imageUrl = Storage::url(basename($imagePath));
            $imageUrl = url($imageUrl);
            Post::create([
                'user_id'=> $userId,
                'image'=> $imageUrl,
                'caption'=>$caption
            ]);
            return redirect('/dashboard');
        }
    }
}
