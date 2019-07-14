<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    /**
     * @return HasOne
     */
    public function photo()
    {
        return $this->hasOne(File::class, 'id', 'photo_id');
    }
}
