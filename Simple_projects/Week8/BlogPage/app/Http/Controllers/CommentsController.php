<?php

namespace OpenBook\Http\Controllers;

use OpenBook\Comment;
use Illuminate\Http\Request;
use OpenBook\Http\Requests\CommentFormRequest;
use Auth;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommentFormRequest $request, $postId)
    {
        if(\Auth::check()){
            $body = $request->get('body');
            \OpenBook\Comment::create(
                [
                    'body'=>$body,
                    'user_id'=>Auth::id(),
                    'blogpost_id'=>$postId,
                ]
            );
            return redirect()->route('post',[$postId]);
        } else {
            return redirect('home');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \OpenBook\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \OpenBook\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \OpenBook\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \OpenBook\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
