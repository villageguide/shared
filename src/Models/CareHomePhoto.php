<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CareHomePhoto extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'care_home_id',
        'file_id',
        'order',
    ];

    /**
     * Get the care home that owns the photo.
     */
    public function careHome()
    {
        return $this->belongsTo(CareHome::class);
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
}
