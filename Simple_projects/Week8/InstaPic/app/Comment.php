<?php

namespace InstaPic;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'content',
        'user_id',
        'post_id',
    ];

    public function user()
    {
        return $this->belongsTo('InstaPic\User');
    }

    public function post()
    {
        return $this->belongsTo('InstaPic\Post');
    }

    public function replies()
    {
        return $this->hasMany('InstaPic\Reply');
    }

    public function addComment($userId, $postId, $content)
    {
        $this->create([
            'content' => $content,
            'user_id' => $userId,
            'post_id' => $postId,
        ]);

        $post = Post::find($postId);
        $commentCount = $post->commentcount;
        $post->update([
            'commentcount' => $commentCount+1,
        ]);
    }

    public function deleteComment($id)
    {
        $comment = $this::find($id);
        $postId = $comment->post_id;
        $comment->delete();
        $post = Post::find($postId);
        $commentCount = $post->commentcount;
        $post->update([
            'commentcount' => $commentCount-1,
        ]);
    }
}
