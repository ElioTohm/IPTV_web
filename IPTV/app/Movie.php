<?php

namespace App;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Movie extends Model
{
    use Searchable;

    public $asYouType = true;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'movies';
    
    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();

        return $array;
    }

    public function genres () 
    {
        return $this->belongsToMany('App\Genre', 'movies_genre', 'movie', 'genre');
    }

    public function stream () 
    {
        return $this->hasOne('App\Stream', 'movie');
    }

    public function purchase()
    {
        return $this->morphMany('App\Purchase', 'purchasable');
    }

}
