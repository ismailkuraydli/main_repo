<?php

namespace InstaPic;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'image',
        'caption',
        'likecount',
        'commentcount',
        'row',
        'column',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo('InstaPic\User');
    }

    public function comments()
    {
        return $this->hasMany('InstaPic\Comment');
    }

    public function liked()
    {
        return $this->belongsToMany('InstaPic\User','likes','post_id','user_id');
    }
}
