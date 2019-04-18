<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PriceRange extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'village_id',
        'price_range_list_id',
        'type',
    ];

    /**
     * @return BelongsToMany
     */
    public function villages()
    {
        return $this->belongsToMany(Village::class);
    }

    public function priceRangeList()
    {
        return $this->hasOne(PriceRangeList::class);
    }
}
