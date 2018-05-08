<?php

namespace App;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Stream extends Model
{
    
    use Searchable;

    public $asYouType = true;

    protected $table = 'streams';
    protected $hidden = array('created_at', 'updated_at');

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

    public function getVidStreamAttribute($value)
    {
        if ($this->channel == NULL) {
            return Storage::disk('public')->url('store/movies/' . $value);
        } else {
            return $value;
        }
        
    }
}
