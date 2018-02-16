<?php

namespace InstaPic;

use Illuminate\Database\Eloquent\Model;

class Directmessage extends Model
{
    protected $fillable = ['content','sender_id','reciever_id'];
    
        public function sender()
        {
            return $this->belongsTo('InstaPic\User','sender_id');
        }
    
        public function reciever()
        {
            return $this->belongsTo('InstaPic\User','reciever_id');
        }
}
