<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Manager extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'village_id',
        'title',
        'name',
        'phone',
        'email',
        'photo_id',
    ];

    /**
     * Get the village that owns the manager.
     */
    public function village()
    {
        return $this->belongsTo(Village::class);
    }


    /**
     * @return HasOne
     */
    public function photo()
    {
        return $this->hasOne(File::class, 'id', 'photo_id');
    }
}
