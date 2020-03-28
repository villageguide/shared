<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'operator_id',
        'content',
        'start_date',
        'end_date',
    ];

    /**
     * @var array
     */
    protected $dates = ['start_date', 'end_date'];

    /**
     * Get the operator that owns the banner.
     */
    public function operator()
    {
        return $this->belongsTo(Operator::class);
    }

    /**
     * @return string
     */
    public function startDate()
    {
        return ($this->start_date) ? $this->start_date->format('d-m-Y') : '';
    }

    /**
     * @return string
     */
    public function endDate()
    {
        return ($this->end_date) ? $this->end_date->format('d-m-Y') : '';
    }
}
