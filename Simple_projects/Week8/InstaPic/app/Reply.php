<?php

namespace InstaPic;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $fillable = ['content','user_id','comment_id'];

    public function user()
    {
        return $this->belongsTo('InstaPic\User');
    }

    public function comment()
    {
        return $this->belongsTo('InstaPic\Comment');
    }
}
