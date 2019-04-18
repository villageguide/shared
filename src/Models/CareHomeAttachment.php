<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CareHomeAttachment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'care_home_id',
        'title',
        'attachment',
    ];

    /**
     * Get the file associated with the user.
     */
    /**
     * @return File|HasOne
     */
    public function attachment()
    {
        return $this->hasOne(File::class, 'id', 'attachment_id');
    }

    /**
     * Get the care home that owns the attachment.
     */
    public function careHome()
    {
        return $this->belongsTo(CareHome::class);
    }
}
