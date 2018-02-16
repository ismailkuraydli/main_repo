<?php

namespace OpenBook\Http\Controllers;

use Auth;
use OpenBook\Blogpost;
use OpenBook\Blog;
use OpenBook\Comment;
use Illuminate\Http\Request;
use OpenBook\Http\Requests\BlogPostFormRequest;

class BlogPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($postId)
    {
        $post = \OpenBook\Blogpost::findOrFail($postId);
        $blogId = $post['blog_id'];
        $blog = \OpenBook\Blog::findOrFail($blogId);
        $comments = \OpenBook\Comment::where('blogpost_id',$postId)->orderBy('created_at','DESC')->simplePaginate(10);
        if($blog['user_id']== \Auth::id()) {
            $postOwner = true;
        } else {
            $postOwner = false;
        }

        return view('blogpost')->with([
            'post'=>$post,
            'postOwner'=>$postOwner,
            'comments'=>$comments,
            'blogId'=>$blogId,
            'blogName'=>$blog['name'],
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($blogId)
    {
        $blog = \OpenBook\Blog::findOrFail($blogId);
        if(\Auth::check() && $blog['user_id']== \Auth::id()) {
            return view('post_create')->with('blogId',$blogId);
        } else {
            return redirect()->route('error')->withErrors("You can not create a post for this blog");
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlogPostFormRequest $request, $blogId)
    {
        $blog = \OpenBook\Blog::findOrFail($blogId);
        if(\Auth::check() && $blog['user_id']== \Auth::id()){
            $title = $request->get('title');
            $body = $request->get('body');
            $image = $request->get('image');
            $tags = $request->get('tags');
    
            \OpenBook\Blogpost::create(
                [
                    'title'=>$title,
                    'body'=>$body,
                    'image'=>$image,
                    'tags'=>$tags,
                    'blog_id'=>$blogId,
                ]
            );
            return redirect()->route('blog',[$blogId]);
        } else {
            return redirect()->route('error')->withErrors("You can not create a post for this blog");
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \OpenBook\Blogpost  $blogpost
     * @return \Illuminate\Http\Response
     */
    public function show(Blogpost $blogpost)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \OpenBook\Blogpost  $blogpost
     * @return \Illuminate\Http\Response
     */
    public function edit($postId)
    {
        //$post = \OpenBook\Blogpost::where('id',$postId)->get();
        $post = \OpenBook\Blogpost::findOrFail($postId);
        $blogId = $post['blog_id'];
        $blog = \OpenBook\Blog::findOrFail($blogId);
        if(\Auth::check() && $blog['user_id']== \Auth::id()) {
            return view('post_edit')->with('post',$post);
        } else {
            return redirect()->route('error')->withErrors("You can not edit this post");
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \OpenBook\Blogpost  $blogpost
     * @return \Illuminate\Http\Response
     */
    public function update(BlogPostFormRequest $request,$postId)
    {
        $post = \OpenBook\Blogpost::findOrFail($postId);
        $blogId = $post['blog_id'];
        $blog = \OpenBook\Blog::findOrFail($blogId);
        if(\Auth::check() && $blog['user_id']== \Auth::id()) {
            $title = $request->get('title');
            $body = $request->get('body');
            $image = $request->get('image');
            $tags = $request->get('tags');
    
            $post->update(
                [
                    
                    'title'=>$title,
                    'body'=>$body,
                    'image'=>$image,
                    'tags'=>$tags,
                    'blog_id'=>$blogId
                    
                ]
            );
            return redirect()->route('blog',[$blogId]);
        } else {
            return redirect()->route('error')->withErrors("You can not edit this post");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \OpenBook\Blogpost  $blogpost
     * @return \Illuminate\Http\Response
     */
    public function destroy($postId)
    {
        $post = \OpenBook\Blogpost::findOrFail($postId);
        $blogId = $post['blog_id'];
        $blog = \OpenBook\Blog::findOrFail($blogId);
        if(\Auth::check() && $blog['user_id']== \Auth::id()) {
            $post->delete();
            return redirect()->route('blog',[$blogId]);
        } else {
            return redirect()->route('error')->withErrors("You can not delete this post");
        }
        
    }
}
