<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Event extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'village_id',
        'title',
    ];

    /**
     * Get the village that owns the event.
     */
    public function village()
    {
        return $this->belongsTo(Village::class);
    }

    /**
     * Get the event times associated with the Event.
     *
     * @return HasMany
     */
    public function eventTimes()
    {
        return $this->hasMany(EventTime::class);
    }

    /**
     * Get the event times associated with the Event.
     *
     * @return HasMany
     */
    public function firstEventTime()
    {
        return $this->eventTimes()->first();
    }

    /**
     * @return string
     */
    public function typeName()
    {
        return ($this->type == 'OpenDay') ? 'Open day' : 'Event';
    }

    /**
     * @return HasOne
     */
    public function image()
    {
        return $this->hasOne(File::class, 'id', 'image_id');
    }

    /**
     * @return string
     */
    public function eventDateName()
    {
        if ($this->eventTimes()->count() > 1) {
            $minDate = $this->eventTimes()->orderBy('Date')->first()->date;
            $maxDate = $this->eventTimes()->orderBy('Date', 'desc')->first()->date;

            if ($minDate->format('m') === $maxDate->format('m')) {
                return sprintf('%s - %s %s', $minDate->format('d'), $maxDate->format('d'), $minDate->format('M'));
            } else {
                return sprintf(
                    '%s %s - %s %s',
                    $minDate->format('d'),
                    $minDate->format('M'),
                    $maxDate->format('d'),
                    $maxDate->format('M')
                );
            }
        }

        $eventTime = $this->eventTimes()->first();

        return $eventTime->date->format('l d F');
    }
}
