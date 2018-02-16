<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
    'content',
    'user_id',
    ];
    /**
     * Relation to User
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
