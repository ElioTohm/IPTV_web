<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stream extends Model
{
    //
    protected $table = 'streams';
    protected $hidden = array('id', 'created_at', 'updated_at');

    public function type ()
    {
        return $this->hasOne('App\StreamType', 'id', 'type');
    }

    public function channel () {
    	return $this->belongsTo('App\Channel', 'stream', 'id');
    }
}
