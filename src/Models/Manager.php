<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    ];

    /**
     * Get the village that owns the manager.
     */
    public function village()
    {
        return $this->belongsTo(Village::class);
    }
}
