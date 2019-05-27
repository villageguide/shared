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
     * @return string
     */
    public function formattedTimeStart()
    {
        $time = Carbon::createFromFormat('H:i:s', $this->time_start)->format('g:ia');

        return str_replace(':00', '', $time);
    }

    /**
     * @return string
     */
    public function formattedTimeEnd()
    {
        $time = Carbon::createFromFormat('H:i:s', $this->time_end)->format('g:ia');

        return str_replace(':00', '', $time);
    }
}
