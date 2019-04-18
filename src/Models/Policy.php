<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Policy extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'village_id',
        'age_criteria',
        'statutory_supervisor',
        'pet_policy',
        'insurance_policy',
    ];

    /**
     * Get the village that owns the policy.
     */
    public function village()
    {
        return $this->belongsTo(Village::class);
    }
}
