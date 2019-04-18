<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DefaultVillageSize extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Get the village that owns the village size.
     */
    public function village()
    {
        return $this->belongsTo(Village::class);
    }
}
