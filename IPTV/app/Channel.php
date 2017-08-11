<?php

namespace App;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    use Searchable;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'channels';
}
