<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;

class Village extends Model
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
        'plan_id',
    ];

    /**
     * The users that belong to the village.
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Get the operator record associated with the village.
     *
     * @return Operator|belongsTo
     */
    public function operator()
    {
        return $this->belongsTo(Operator::class);
    }

    /**
     * Get the address record associated with the village.
     *
     * @return Address|BelongsTo
     */
    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    /**
     * Get the accommodation options associated with the village.
     *
     * @return HasMany
     */
    public function accommodationOptions()
    {
        return $this->hasMany(AccommodationOption::class);
    }

    /**
     * Get the living option associated with the village.
     *
     * @return LivingOption|HasOne
     */
    public function livingOption()
    {
        return $this->hasOne(LivingOption::class);
    }

    /**
     * Get the legal titles associated with the village.
     *
     * @return HasMany
     */
    public function legalTitles()
    {
        return $this->hasMany(LegalTitle::class);
    }

    /**
     * Get the policy associated with the village.
     *
     * @return Policy|HasOne
     */
    public function policy()
    {
        return $this->hasOne(Policy::class);
    }

    /**
     * Get the facilities associated with the village.
     *
     * @return HasMany
     */
    public function facilities()
    {
        return $this->hasMany(Facility::class);
    }

    /**
     * Get the attractions associated with the village.
     *
     * @return HasMany
     */
    public function attractions()
    {
        return $this->hasMany(Attraction::class);
    }

    /**
     * Get the weblinks associated with the village.
     *
     * @return HasMany
     */
    public function weblinks()
    {
        return $this->hasMany(WebLink::class);
    }

    /**
     * Get the attachments associated with the village.
     *
     * @return HasMany
     */
    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    /**
     * Get the mangers associated with the village.
     */
    public function managers()
    {
        return $this->hasMany(Manager::class);
    }

    /**
     * Get the enquiry emails associated with the village.
     */
    public function enquiryEmails()
    {
        return $this->hasMany(EnquiryEmail::class);
    }

    /**
     * Get the securities associated with the village.
     *
     * @return HasMany
     */
    public function securities()
    {
        return $this->hasMany(Security::class);
    }

    /**
     * @return HasMany
     */
    public function priceRanges()
    {
        return $this->hasMany(PriceRange::class);
    }

    /**
     * Get the videos associated with the village.
     *
     * @return HasMany
     */
    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    /**
     * Get the activities associated with the village.
     *
     * @return HasMany
     */
    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    /**
     * Get the facilities associated with the village.
     *
     * @return BelongsToMany
     */
    public function fscFilters()
    {
        return $this->belongsToMany(FSCFilter::class);
    }

    /**
     * Get the services associated with the village.
     *
     * @return HasMany
     */
    public function services()
    {
        return $this->hasMany(Service::class);
    }

    /**
     * Get the care options associated with the village.
     *
     * @return HasMany
     */
    public function careOptions()
    {
        return $this->hasMany(CareOption::class);
    }

    /**
     * Get the level of cares associated with the village.
     *
     * @return HasMany
     */
    public function levelOfCares()
    {
        return $this->hasMany(LevelOfCare::class);
    }

    /**
     * Get the enquires associated with the village.
     *
     * @return HasMany
     */
    public function enquiries()
    {
        return $this->hasMany(Enquiry::class);
    }

    /**
     * Get the plan record associated with the village.
     *
     * @return Plan|HasOne
     */
    public function plan()
    {
        return $this->hasOne(Plan::class, 'id', 'plan_id');
    }

    /**
     * @return Photo
     */
    public function mainPhoto()
    {
        return $this->photos()->where('order', '1')->first();
    }

    /**
     * Get the photos associated with the village.
     *
     * @return HasMany
     */
    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    /**
     * Get the care home record associated with the village.
     *
     * @return CareHome|HasOne
     */
    public function careHome()
    {
        return $this->hasOne(CareHome::class, 'id', 'care_home_id');
    }


    /**
     * @return string
     */
    public function draftURL()
    {
        return sprintf('http://villageguide.co.nz/village/%s/draft', $this->url_segment);
    }

    /**
     * @return HasOne
     */
    public function logo()
    {
        return $this->hasOne(File::class, 'id', 'logo_id');
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
     * Get the plan record associated with the village.
     *
     * @return DefaultVillageSize|HasOne
     */
    public function villageSize()
    {
        return $this->hasOne(DefaultVillageSize::class, 'id', 'village_size_id');
    }

    /**
     * Get the properties associated with the village.
     *
     * @return HasMany
     */
    public function properties()
    {
        return $this->hasMany(Property::class);
    }

    /**
     * @return Collection
     */
    public function eventList()
    {
        return $this->events()
            ->select('events.*')
            ->where('event_times.date', '>=', Carbon::now())
            ->with('eventTimes')
            ->join('event_times', 'event_times.event_id', '=', 'events.id')
            ->groupBy('events.id')
            ->orderBy('event_times.date')
            ->get();
    }

    /**
     * Get the events associated with the village.
     *
     * @return HasMany
     */
    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
