<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CareHome extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'website',
        'description',
        'operator_id',
        'logo_id',
    ];

    /**
     * The users that belong to the care home.
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Get the operator record associated with the careHome.
     *
     * @return Operator|belongsTo
     */
    public function operator()
    {
        return $this->belongsTo(Operator::class);
    }

    /**
     * @return HasOne|File
     */
    public function logo()
    {
        return $this->hasOne(File::class, 'id', 'logo_id');
    }

    /**
     * Get the village record associated with the careHome.
     *
     * @return Operator|belongsTo
     */
    public function village()
    {
        return $this->belongsTo(Village::class, 'id', 'care_home_id');
    }

    /**
     * Get the room type associated with the care home.
     *
     * @return HasMany
     */
    public function roomTypes()
    {
        return $this->hasMany(RoomType::class);
    }

    /**
     * Get the level of care associated with the care home.
     *
     * @return HasMany
     */
    public function levelOfCare()
    {
        return $this->hasMany(LevelOfCareHome::class);
    }

    /**
     * Get the facilities associated with the care home.
     *
     * @return HasMany
     */
    public function facilities()
    {
        return $this->hasMany(CareHomeFacility::class);
    }

    /**
     * Get the activities associated with the care home.
     *
     * @return HasMany
     */
    public function activities()
    {
        return $this->hasMany(CareHomeActivity::class);
    }

    /**
     * Get the meals associated with the care home.
     *
     * @return HasMany
     */
    public function meals()
    {
        return $this->hasMany(Meal::class);
    }

    /**
     * Get the care options associated with the care home.
     *
     * @return HasMany
     */
    public function careOptions()
    {
        return $this->hasMany(CareHomeCareOption::class);
    }

    /**
     * Get the address record associated with the care home.
     *
     * @return Address|BelongsTo
     */
    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    /**
     * Get the mangers associated with the care home.
     */
    public function managers()
    {
        return $this->hasMany(CareHomeManager::class);
    }

    /**
     * Get the enquiry emails associated with the care home.
     */
    public function enquiryEmails()
    {
        return $this->hasMany(CareHomeEnquiryEmail::class);
    }

    /**
     * Get the attachments associated with the care home.
     *
     * @return HasMany
     */
    public function attachments()
    {
        return $this->hasMany(CareHomeAttachment::class);
    }

    /**
     * @return Photo
     */
    public function mainPhoto()
    {
        return $this->photos()->where('order', '1')->first();
    }

    /**
     * Get the photos associated with the care home.
     *
     * @return HasMany
     */
    public function photos()
    {
        return $this->hasMany(CareHomePhoto::class)->orderBy('order');
    }

    /**
     * @return string
     */
    public function draftURL()
    {
        return sprintf('http://villageguide.co.nz/care-home/%s/draft', $this->url_segment);
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return ($this->status == 'Active');
    }

    /**
     * @return bool
     */
    public function isDraft()
    {
        return ($this->status == 'Draft');
    }

    /**
     * @return Collection
     */
    public function roomTypesActiveOrder()
    {
        return $this->roomTypes()->where('status', 'Active')
            ->where('name', '!=', 'Retirement Village')
            ->orderByRaw('FIELD(name, "Standard", "Premium", "Care suites", "Retirement Village")')
            ->get();
    }

    /**
     * @return Model|TypesOfHome
     */
    public function roomTypeRetirementVillage()
    {
        return $this->roomTypes()->where([
            'status' => 'Active',
            'name'   => 'Retirement Village',
        ])->first();
    }

    /**
     * @return array
     */
    public function imagesForSlider()
    {
        $photoArray = [];
        foreach ($this->photos as $photo) {
            array_push(
                $photoArray,
                [
                    'thumb' => asset($photo->file->resize(120, 90)),
                    'src'   => asset($photo->file->resize(1100, 607)),
                ]
            );
        }

        return $photoArray;
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function isActiveLevelOfCare($name)
    {
        return (in_array($name, $this->levelOfCare()->pluck('name', 'name')->toArray()));
    }
}
