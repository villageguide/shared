<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Property extends Model
{

    /**
     * Get the village that owns the event.
     */
    public function village()
    {
        return $this->belongsTo(Village::class);
    }

    /**
     * @return Property
     */
    public function mainPhoto()
    {
        return $this->photos()->first();
    }

    /**
     * @return HasMany
     */
    public function photos()
    {
        return $this->hasMany(PropertyPhoto::class);
    }

    /**
     * @return array
     */
    public function accommodationArray()
    {
        return $this->accommodations()->pluck('default_id', 'default_id')->toArray();
    }

    /**
     * @return HasMany
     */
    public function accommodations()
    {
        return $this->hasMany(PropertyAccommodation::class);
    }
}
