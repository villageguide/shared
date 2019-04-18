<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CareHomeCareOption extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'care_home_id',
        'name',
        'is_default',
    ];

    /**
     * Get the care home that owns the care option.
     */
    public function careHome()
    {
        return $this->belongsTo(CareHome::class);
    }
}
