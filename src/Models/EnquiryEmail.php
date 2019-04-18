<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnquiryEmail extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'village_id',
        'email',
    ];

    /**
     * Get the village that owns the enquiry email.
     */
    public function village()
    {
        return $this->belongsTo(Village::class);
    }
}
