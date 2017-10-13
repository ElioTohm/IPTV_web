<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StreamType extends Model
{
    protected $table = 'stream_types';
    protected $hidden = array('created_at', 'updated_at');
}