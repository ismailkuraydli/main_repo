<?php

namespace InstaPic;

use Illuminate\Database\Eloquent\Model;

use InstaPic\Post;
use Auth;
class Like extends Model
{
    protected $fillable = [
        'user_id', 'post_id'
    ];

    public function likePost($userId, $postId)
    {
        $this->create([
            'user_id' => $userId,
            'post_id' => $postId,
        ]);

        $post = Post::find($postId);
        $likeCount = $post->likecount;
        $post->update([
            'likecount' => $likeCount+1,
        ]);
    }

    public function unLikePost($userId,$postId)
    {
        $likes = new Like;
        $likes = $likes->where([['user_id',$userId],['post_id',$postId]])->getQuery()->delete();
        if($likes != 0) {
            $post = Post::find($postId);
            $likeCount = $post->likecount;
            $post->update([
                'likecount' => $likeCount-1,
            ]);
        }
    }
}
