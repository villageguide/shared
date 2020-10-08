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

    /**
     * @return mixed
     */
    public function village()
    {
        return $this->hasOne(Village::class, 'id', 'village_id');
    }

    /**
     * @return mixed
     */
    public function careHome()
    {
        return $this->hasOne(CareHome::class, 'id', 'care_home_id');
    }

    /**
     * @return mixed|string
     */
    public function typeName()
    {
        if ($this->type == 'village') {
            return ($this->village) ? $this->village->name : '';
        }

        return ($this->careHome) ? $this->careHome->name : '';
    }

    /**
     * @return mixed|string
     */
    public function typeOperatorName()
    {
        if ($this->type == 'village') {
            return ($this->village) ? $this->village->operator->name : '';
        }

        return ($this->careHome) ? $this->careHome->operator->name : '';
    }

    /**
     * @return mixed|string
     */
    public function typeId()
    {
        if ($this->type == 'village') {
            return ($this->village) ? $this->village->id : '';
        }

        return ($this->careHome) ? $this->careHome->id : '';
    }
}
