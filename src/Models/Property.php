<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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

    /**
     * @return BelongsTo
     */
    public function favourite()
    {
        if (class_exists(Favourite::class)) {
            return Favourite::where([
                'type'      => 'Property',
                'type_id'   => $this->id,
                'member_id' => Auth::user()->id,
            ])->first();
        }
    }

    /**
     * @return string
     */
    public function link()
    {
        return sprintf('property/%s', Str::slug($input['title'], '-'));
    }
}
