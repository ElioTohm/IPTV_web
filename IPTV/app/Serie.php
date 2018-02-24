<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    //
    public function purachse()
    {
        return $this->morphMany('App\Purchase', 'purchasable');
    }
}
