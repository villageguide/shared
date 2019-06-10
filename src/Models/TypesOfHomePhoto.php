<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TypesOfHomePhoto extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'types_of_home_id',
        'file_id',
        'order',
    ];

    /**
     * Get the types of home that owns the photo.
     */
    public function typesOfHome()
    {
        return $this->belongsTo(TypesOfHome::class);
    }

    /**
     * Get the file associated with the user.
     */
    /**
     * @return File|HasOne
     */
    public function file()
    {
        return $this->hasOne(File::class, 'id', 'file_id');
    }
}
