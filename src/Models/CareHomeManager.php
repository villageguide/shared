<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CareHomeManager extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'care_home_id',
        'title',
        'name',
        'phone',
        'email',
    ];

    /**
     * Get the care home that owns the manager.
     */
    public function careHome()
    {
        return $this->belongsTo(careHome::class);
    }
}
