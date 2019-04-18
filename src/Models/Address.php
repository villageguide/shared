<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Address extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'street',
        'town',
        'region_id',
        'district_id',
        'postcode',
        'country_id',
    ];

    /**
     * Get the village that owns the address.
     */
    public function village()
    {
        return $this->hasOne(Village::class);
    }

    /**
     * Get the country record associated with the address.
     *
     * @return Country|HasOne
     */
    public function country()
    {
        return $this->hasOne(Country::class);
    }

    /**
     * Get the region record associated with the address.
     *
     * @return Region|HasOne
     */
    public function region()
    {
        return $this->hasOne(Region::class, 'id', 'region_id');
    }

    /**
     * Get the district record associated with the address.
     *
     * @return District|HasOne
     */
    public function district()
    {
        return $this->hasOne(District::class, 'id', 'district_id');
    }

    /**
     * Get the care home that owns the address.
     */
    public function careHome()
    {
        return $this->hasOne(CareHome::class);
    }

    /**
     * @return string
     */
    public function fullAddress()
    {
        return sprintf(
            '%s, %s, %s',
            $this->street,
            $this->town,
            $this->region->name
        );
    }
}
