<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TypesOfHome extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'village_id',
        'name',
        'is_default',
    ];

    /**
     * Get the village that owns the types of home.
     */
    public function village()
    {
        return $this->belongsTo(Village::class);
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
        return $this->hasMany(TypesOfHomePhoto::class);
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
                    'src'   => asset($photo->file->resize(1100, 607)),
                ]
            );
        }

        return $photoArray;
    }
}
