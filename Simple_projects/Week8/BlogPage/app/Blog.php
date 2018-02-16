<?php

namespace OpenBook;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{

    protected $fillable = [
        'name','description','user_id'
    ];

    public function blogposts()
    {
        return $this->hasMany('OpenBook\Blogpost');
    }

    public function user()
    {
        return $this->belongsTo('OpenBook\User');
    }
    //
}
