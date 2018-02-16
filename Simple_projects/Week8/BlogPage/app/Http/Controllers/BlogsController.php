<?php

namespace OpenBook\Http\Controllers;

use Auth;
use OpenBook\Blog;
use OpenBook\Blogpost;
use Illuminate\Http\Request;
use OpenBook\Http\Requests\CreateBlogFormRequest;

class BlogsController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($blogId)
    {
        $blog = \OpenBook\Blog::findOrFail($blogId);
        $posts = \OpenBook\Blogpost::where('blog_id',$blogId)->orderBy('created_at','desc')->simplePaginate(3);
        if($blog['user_id'] === \Auth::id()) {
            $blogOwner = true;
        } else {
            $blogOwner = false;
        }
        return view('blog')->with(
            [
                'posts'=>$posts,
                'blogId'=>$blogId,
                'blogName'=>$blog['name'],
                'blogOwner'=>$blogOwner
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {  
        if(\Auth::check()) {
            return view('blog_create');
        } else {
            return redirect('home');
        }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateBlogFormRequest $request)
    {
        if(!Auth::check()) {
            return redirect()->route('error')->withErrors("You are not logged in");
        }
        $name = $request->get('name');
        $description = $request->get('description');
        $userId = Auth::user()->id;
        \OpenBook\Blog::create(
            [
                'name'=> $name,
                'description' => $description,
                'user_id' => $userId,
            ]
        );
        return redirect('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  \OpenBook\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog)
    {
        $blogs = \OpenBook\Blog::where('user_id','<>',Auth::user()->id)->orderBy('created_at','desc')->simplePaginate(5);
        return view('dashboard')->with('blogs',$blogs);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \OpenBook\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \OpenBook\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blog $blog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \OpenBook\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy($blogId)
    {
        $blog = \OpenBook\Blog::findOrFail($blogId);
        if(\Auth::check() && $blog['user_id']== \Auth::id()) {
            $blog->delete();
            return redirect()->route('home');
        } else {
            return redirect()->route('error')->withErrors("You can not delete this blog");
        }
    }
}
