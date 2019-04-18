<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Photo extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'village_id',
        'file_id',
        'order',
    ];

    /**
     * Get the village that owns the photo.
     */
    public function village()
    {
        return $this->belongsTo(Village::class);
    }

    /**
     * Get the file associated with the user.
     */
    /**
     * @return File|HasOne
     */
    public function file()
    {
        return $this->hasOne(File::class, 'id', 'file_id');
    }

    /**
     * Get the care home that owns the photo.
     */
    public function careHome()
    {
        return $this->belongsTo(CareHome::class);
    }
}
