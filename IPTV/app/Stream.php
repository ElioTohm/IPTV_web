<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stream extends Model
{
    //
    protected $table = 'streams';
    protected $hidden = array('created_at', 'updated_at');

    public function type ()
    {
        return $this->hasOne('App\StreamType', 'id', 'type');
    }

    public function channel () {
    	return $this->hasOne('App\Channel', 'id', 'channel');
    }

    public function movies () {
        return $this->hasOne('App\Movie', 'id', 'movie');
    }
}
