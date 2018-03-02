<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Genre extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'genres';
    protected $hidden = array('pivot', 'created_at', 'updated_at');

    public function getPosterAttribute($value)
    {
        return $url = Storage::disk('public')->url('/genres/' . $value);
    }
}
