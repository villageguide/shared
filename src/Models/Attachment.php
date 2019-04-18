<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Attachment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'village_id',
        'title',
        'attachment',
    ];

    /**
     * Get the village that owns the attachment.
     */
    public function village()
    {
        return $this->belongsTo(Village::class);
    }

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
