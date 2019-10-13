<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RoomType extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'care_home_id',
        'name',
        'is_default',
    ];

    /**
     * Get the care home that owns the room type.
     */
    public function careHome()
    {
        return $this->belongsTo(CareHome::class);
    }

    /**
     * @return Model|HasMany|object|null
     */
    public function mainPhoto()
    {
        return $this->photos()->where('order', '1')->first();
    }

    /**
     * Get the photos associated with the types of home.
     *
     * @return HasMany
     */
    public function photos()
    {
        return $this->hasMany(RoomTypePhoto::class);
    }

    /**
     * @return array
     */
    public function renderPhotos()
    {
        $photos = $this->photos()->limit(10)->orderBy('id', 'asc')->get();

        $photoLinkArray = [];
        if ($photos->count() > 0) {
            foreach ($photos as $photo) {
                $photoLinkArray[$photo->order] = $photo->file->filepath;
            }
        }

        return $photoLinkArray;
    }

    /**
     * @return array
     */
    public function imagesForSlider()
    {
        $photoArray = [];
        foreach ($this->photos as $photo) {
            array_push(
                $photoArray,
                [
                    'thumb' => asset($photo->file->resize(120, 90)),
                    'src'   => asset($photo->file->widen(1100, 607)),
                ]
            );
        }

        return $photoArray;
    }
}
