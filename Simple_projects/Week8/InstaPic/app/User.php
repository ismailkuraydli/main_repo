<?php

namespace InstaPic;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use InstaPic\Comment;
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email', 
        'password',
        'displayname',
        'avatar',
        'bio',
        'cover',
        'website',
        'gender',
        'mobile',
        'followercount',
        'followingcount',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function comments() 
    {
        return $this->hasMany('InstaPic\Comment');
    }

    public function sentDirectMessages()
    {
        return $this->hasMany('InstaPic\Directmessage','sender_id');
    }

    public function recievedDirectMessages()
    {
        return $this->hasMany('InstaPic\Directmessage','reciever_id');
    }

    public function following()
    {
        return $this->belongsToMany('InstaPic\User','follows','user_id','following_id')->withTimeStamps();
    }

    public function followers()
    {
        return $this->belongsToMany('InstaPic\User','follows','following_id','user_id')->withTimeStamps();
    }

    public function likes()
    {
        return $this->belongsToMany('InstaPic\Post','likes','user_id','post_id');
    }

    public function posts()
    {
        return $this->hasMany('InstaPic\Post','user_id');
    }

    public function replies()
    {
        return $this->hasMany('InstaPic\Reply');
    }
}
