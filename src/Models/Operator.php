<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Operator extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'logo_id',
        'created_by',
        'status',
    ];

    /**
     * Get the villages associated with the operator.
     *
     * @return HasMany
     */
    public function villages()
    {
        return $this->hasMany(Village::class);
    }

    /**
     * @return mixed
     */
    public function allUsers()
    {
        $villages = $this->villages->pluck('id')->toArray();

        return User::whereHas('villages', function ($q) use ($villages) {
            $q->whereIn('villages.id', $villages);
        })->get();
    }

    /**
     * Get the user record associated with the operator.
     *
     * @return HasOne
     */
    public function createdBy()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    /**
     * Get the care homes associated with the operator.
     *
     * @return HasMany
     */
    public function careHomes()
    {
        return $this->hasMany(CareHome::class);
    }

    /**
     * @return HasOne|File
     */
    public function logo()
    {
        return $this->hasOne(File::class, 'id', 'logo_id');
    }

    /**
     * Get the user record associated with the operator.
     *
     * @return HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * @return string
     */
    public function publicLink()
    {
        return sprintf('/operator/%s', $this->url_segment);
    }

    /**
     * @return Collection
     */
    public function properties()
    {
        $properties = new Collection();
        $villageIds = $this->villages()->pluck('id', 'id')->toArray();
        if (!empty($villageIds)) {
            $properties = Property::whereIn('village_id', $villageIds)->get();
        }

        return $properties;
    }

    /**
     * @return array
     */
    public function enquiries()
    {
        $villageIdArray = $this->villages->pluck('id', 'id')->toArray();
        if (count($villageIdArray) > 0) {
            return Enquiry::whereIn('village_id', $villageIdArray)->orderBy('created_at', 'desc');
        }

        return [];
    }

    /**
     * @return HasMany
     */
    public function reportEmails()
    {
        return $this->hasMany(ReportEmail::class);
    }

    /**
     * @return int
     */
    public function countActiveTypesOfHomes()
    {
        $activeItems = $this->typesOfHomes()->where('status', 'Active')->get();
        $count = 0;

        foreach ($activeItems as $item) {
            if ($item->mainPhoto()) {
                $count++;
            }
        }

        return $count;
    }
}
