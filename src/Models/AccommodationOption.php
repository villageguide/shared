<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccommodationOption extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'village_id',
        'name',
        'is_default',
    ];

    /**
     * Get the village that owns the accommodation option.
     */
    public function village()
    {
        return $this->belongsTo(Village::class);
    }
}
