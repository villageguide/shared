<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebLink extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'village_id',
        'title',
        'weblink',
    ];

    /**
     * Get the village that owns the weblink.
     */
    public function village()
    {
        return $this->belongsTo(Village::class);
    }
}
