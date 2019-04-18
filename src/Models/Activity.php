<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
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
     * Get the village that owns the attraction.
     */
    public function village()
    {
        return $this->belongsTo(Village::class);
    }
}
