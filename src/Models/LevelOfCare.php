<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LevelOfCare extends Model
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
     * Get the village that owns the level of care.
     */
    public function village()
    {
        return $this->belongsTo(Village::class);
    }
}
