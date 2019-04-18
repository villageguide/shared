<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LivingOption extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'village_id',
        'independent_living',
        'assisted_living',
        'rest_home_care',
        'hospital_care',
        'dementia_care',
        'r_v_a_accredited_village',
    ];

    /**
     * Get the village that owns the living option.
     */
    public function village()
    {
        return $this->belongsTo(Village::class);
    }

}
