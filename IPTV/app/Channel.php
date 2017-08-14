<?php

namespace App;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    use Searchable;

    public $asYouType = true;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'channels';

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
        return $this->belongsToMany('App\Genre', 'channel_genre', 'channel', 'genre');
    }
}
