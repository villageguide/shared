<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'village_id',
        'title',
        'link',
    ];

    /**
     * Get the village that owns the weblink.
     */
    public function village()
    {
        return $this->belongsTo(Village::class);
    }

    /**
     * @return string
     */
    public function getVideoId()
    {
        parse_str(parse_url($this->link, PHP_URL_QUERY), $arrayOfVars);

        return $arrayOfVars['v'];
    }

    /**
     * @return string
     */
    public function getYoutubeEmbedURL()
    {
        return sprintf('https://www.youtube.com/embed/%s?controls=0', $this->getVideoId());
    }

    /**
     * @return string
     */
    public function getThumbImage()
    {
        if (stripos($this->link, 'youtu') === false) {
            return asset('images/video-thumb.png');
        } else {
            parse_str(parse_url($this->link, PHP_URL_QUERY), $arrayOfVars);
            return sprintf('https://img.youtube.com/vi/%s/0.jpg', $this->getVideoId());
        }
    }
}
