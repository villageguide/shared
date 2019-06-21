<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'filepath',
        'extension'
    ];

    /**
     * Get the user that owns the file.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the attachment that owns the file.
     */
    public function attachment()
    {
        return $this->belongsTo(Attachment::class);
    }

    /**
     * Get the village that owns the file.
     */
    public function village()
    {
        return $this->belongsTo(Village::class);
    }

    /**
     * Get the care home that owns the file.
     */
    public function careHome()
    {
        return $this->belongsTo(CareHome::class);
    }

    /**
     * Get the operator that owns the file.
     */
    public function operator()
    {
        return $this->belongsTo(Operator::class);
    }

    /**
     * Get the operator that owns the file.
     */
    public function propertyPhoto()
    {
        return $this->belongsTo(PropertyPhoto::class);
    }

    /**
     *  Delete file in the storage
     */
    public function delete()
    {
        parent::delete();
        Storage::delete($this->filepath);
    }

    /**
     * Get the manager that owns the file.
     */
    public function manager()
    {
        return $this->belongsTo(Manager::class);
    }
}
