<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'genres';
    protected $hidden = array('pivot', 'created_at', 'updated_at');
}
