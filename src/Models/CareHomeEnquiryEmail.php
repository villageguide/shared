<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CareHomeEnquiryEmail extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'care_home_id',
        'email',
    ];

    /**
     * Get the care home that owns the enquiry email.
     */
    public function careHome()
    {
        return $this->belongsTo(CareHome::class);
    }
}
