<?php

namespace App;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use Searchable;
    
    public $asYouType = true;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'devices';
     
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

    /**
     * Get the device associated with the oauth.
     */
     public function Authclient()
     {
         return $this->hasOne('App\oAuthClient', 'id')->select('id','secret');
     }
}
