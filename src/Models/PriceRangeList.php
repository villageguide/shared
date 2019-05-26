<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriceRangeList extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'min_price',
        'max_price',
        'name',
    ];
}
