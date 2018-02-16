<?php

namespace OpenBook;

use Illuminate\Database\Eloquent\Model;

class Blogpost extends Model
{
    //

    protected $fillable = [
        'title','body','image','tags','blog_id'
    ];

    public function blog()
    {
        return $this->belongsTo('app/Blog');
    }

    public function comments()
    {
        return $this->hasMany('app/Comment');
    }
}
