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

    public function purchases () 
    {
        return $this->hasMany('App\Purchase', 'client_id', 'id');
    }

    
    public function getwelcomeImageAttribute($value)
    {
        return env('APP_URL', 'localhost') . "/images/device/welcome/" . urlencode($value);
    }

    public function getBalanceAttribute($value)
    {
        $purchases = $this->purchases;
        $bill = 0;
        foreach ($purchases as $purchase) {
            $bill = $bill + $purchase->purchasable->price;
        }

        return $value - $bill;
    }
}
