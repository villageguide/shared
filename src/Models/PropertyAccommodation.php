<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropertyAccommodation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'property_id',
        'default_id',
    ];

    /**
     * @return BelongsTo
     */
    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
