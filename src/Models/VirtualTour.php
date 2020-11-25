<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VirtualTour extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'village_id',
        'care_home_id',
        'iframe',
    ];

    /**
     * Get the village that owns the weblink.
     */
    public function village()
    {
        return $this->belongsTo(Village::class);
    }

    /**
     * Get the care home that owns the weblink.
     */
    public function careHome()
    {
        return $this->belongsTo(CareHome::class);
    }
}
