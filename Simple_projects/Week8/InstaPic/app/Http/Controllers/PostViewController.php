<?php

namespace InstaPic\Http\Controllers;

use Illuminate\Http\Request;

use InstaPic\Post;
use InstaPic\Comment;
use InstaPic\Reply;
use InstaPic\Http\Requests\CommentFormRequest;
use InstaPic\Http\Requests\ReplyFormRequest;
use Auth;
use InstaPic\Like;
use InstaPic\Follow;
class PostViewController extends Controller
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
    public function index($postId)
    {
        $post = Post::findOrFail($postId);
        $comments = $post->comments;
        return view('post_view',[
            'post'=>$post,
            'comments'=>$comments,
        ]);
    }
    /**
     * Add a comment.
     *
     * @return \Illuminate\Http\Response
     */
    public function comment(CommentFormRequest $request,$postId)
    {
        $content = $request['content'];
        $comment = new Comment;
        $comment->addComment(Auth::id(),$postId,$content);
        return redirect()->back();
    }
    /**
     * Add reply on a comment.
     *
     * @return \Illuminate\Http\Response
     */
    public function reply(ReplyFormRequest $request,$commentId)
    {
        $content = $request['content'];
        $reply = new Reply;
        $reply->create([
            'content'=>$content,
            'user_id'=>Auth::id(),
            'comment_id'=>$commentId,
        ]);
        return redirect()->back();
    }
    /**
     * Like a post
     *
     * @return \Illuminate\Http\Response
     */
    public function like($postId)
    {
        $like = new Like;
        $like->likePost(Auth::id(),$postId);
        return redirect('dashboard');
    }
    /**
     * unLike a post
     *
     * @return \Illuminate\Http\Response
     */
    public function unLike($postId)
    {
        $like = new Like;
        $like->unLikePost(Auth::id(),$postId);
        return redirect('dashboard');
    }
    /**
     * Follow a user
     *
     * @return \Illuminate\Http\Response
     */
    public function follow($userId)
    {
        $follow = new Follow;
        $follow->follow(Auth::id(),$userId);
        return redirect('explore');
    }

}
