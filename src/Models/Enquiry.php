<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'village_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'street_address',
        'city',
        'postcode',
        'country_id',
        'subject',
        'message',
        'note',
        'contacted'
    ];

    /**
     * Get the village that owns the weblink.
     */
    public function village()
    {
        return $this->belongsTo(Village::class);
    }

    /**
     * @return string
     */
    public function fullName()
    {
        return trim(sprintf('%s %s', $this->first_name, $this->last_name));
    }

    /**
     * @return string
     */
    public function fullAddress()
    {
        return sprintf('%s %s %s', $this->street_address, $this->city, $this->postcode);
    }
}
