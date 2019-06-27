<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class EventTime extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'event_id',
        'date',
        'date_end',
        'time_start',
        'time_end',
    ];
    /**
     * @var array
     */
    protected $dates = [
        'date',
        'date_end',
    ];

    /**
     * Get the event that owns the event time.
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * @param boolean $isBackEnd
     *
     * @return string
     */
    public function formattedTimeStart($isBackEnd = false)
    {
        $startDate = Carbon::createFromFormat('H:i:s', $this->time_start);
        $time = $startDate->format('g:ia');

        if ($isBackEnd) {
            return $startDate->format('g:i A');

        }

        return str_replace(':00', '', $time);
    }

    /**
     * @return string
     */
    public function formattedTimeEnd($isBackEnd = false)
    {
        $endTime = Carbon::createFromFormat('H:i:s', $this->time_end);
        $time = $endTime->format('g:ia');

        if ($isBackEnd) {
            return $endTime->format('g:i A');
        }

        return str_replace(':00', '', $time);
    }
}
