<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Name',
        'Code',
    ];

    /**
     * Get the address that owns the country.
     */
    public function address()
    {
        return $this->belongsTo(Address::class);
    }
}
