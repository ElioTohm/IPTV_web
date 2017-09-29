<?php

namespace App;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use Searchable;
    
    public $asYouType = true;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'clients';
     
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
}
