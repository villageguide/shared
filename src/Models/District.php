<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    public $timestamps = true;

    /**
     * Get the address that owns the district.
     */
    public function address()
    {
        return $this->belongsTo(Address::class);
    }
}
