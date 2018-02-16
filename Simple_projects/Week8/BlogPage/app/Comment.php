<?php

namespace OpenBook;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public $timestamps = true;
    protected $fillable = ['body','user_id','blogpost_id'];

    public function blogpost() {
        return $this->belongsTo('OpenBook\Blogpost');
    }
    public function user() {
        return $this->belongsTo('OpenBook\User');
    }
}
