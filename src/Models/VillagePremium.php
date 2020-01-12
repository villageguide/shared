<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class VillagePremium extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'custom_file_id',
    ];

    /**
     * Get the village record associated with the Village premium.
     *
     * @return Village|BelongsTo
     */
    public function village()
    {
        return $this->belongsTo(Village::class);
    }

    /**
     * Get the file associated with the village premium.
     */
    /**
     * @return File|HasOne
     */
    public function file()
    {
        return $this->hasOne(File::class, 'id', 'custom_file_id');
    }
}
