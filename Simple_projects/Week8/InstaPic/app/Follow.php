<?php

namespace InstaPic;

use Illuminate\Database\Eloquent\Model;

use InstaPic\User;
class Follow extends Model
{
    protected $fillable = [
        'user_id', 'following_id'
    ];

    public function follow($followerId, $followingId)
    {
        $this->create([
            'user_id' => $followerId,
            'following_id' => $followingId,
        ]);

        $user = User::find($followerId);
        $followingCount = $user->followingcount;
        $user->update([
            'followingcount' => $followingCount+1,
        ]);

        $followed = User::find($followingId);
        $followerCount = $followed->followecount;
        $followed->update([
            'followercount'=>$followerCount +1,
        ]);
    }

    public function unFollow($id)
    {
        $follow = Follow::find($id);
        $userId = $follow->user_id;
        $followedId = $follow->following_id;
        $follow->delete();
        
        $user = User::find($userId);
        $followed = User::find($followedId);
        $followingCount = $user->followingcount;
        $followerCount = $followed->followecount;
        $user->update([
            'followingcount' => $followingcount-1,
        ]);
        $followed->update([
            'followercount'=>$followerCount -1,
        ]);
    } 
}
