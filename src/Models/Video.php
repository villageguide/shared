<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'village_id',
        'title',
        'link',
    ];

    /**
     * Get the village that owns the weblink.
     */
    public function village()
    {
        return $this->belongsTo(Village::class);
    }
}
