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
        $array =  [
            'id' => $this->id,
            'name' => $this->title,
            'email' => $this->email,
            'room' => $this->room,
            'welcome_message' => $this->welcome_message,
            'welcome_image' => $this->welcome_image,
            'balance' => $this->balance,
        ];

        if (!empty(self::$purchases))
            $array = array_merge($array, self::$purchases);

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
