<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Advert extends Model
{
    protected $dates = ['start_date','end_date' ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'region',
        'start_date',
        'end_date',
        'file_id',
    ];

    /**
     * @return File|HasOne
     */
    public function image()
    {
        return $this->hasOne(File::class, 'id', 'file_id');
    }

    /**
     * @return string
     */
    public function regionName()
    {
        if ($this->region) {
            return Region::find($this->region)->first()->name;
        }
    }
}
