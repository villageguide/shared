<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VirtualTour extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'village_id',
        'care_home_id',
        'iframe',
    ];

    /**
     * Get the village that owns the weblink.
     */
    public function village()
    {
        return $this->belongsTo(Village::class);
    }

    /**
     * Get the care home that owns the weblink.
     */
    public function careHome()
    {
        return $this->belongsTo(CareHome::class);
    }

    /**
     * @return string|string[]|null
     */
    public function tourForModal()
    {
        return preg_replace(
            ['/height="\d+"/i', '/width="\d+"/i'],
            [sprintf('height="%d"', 600), sprintf('width="%s"', '100%')],
            $this->iframe
        );
    }
}
