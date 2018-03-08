<?php

namespace App;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Service extends Model
{
    use Searchable;

    public $asYouType = false;

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

    public function getIconAttribute($value)
    {
        return $url = Storage::disk('public')->url('/hotel/images/' . $value);
    }
}
