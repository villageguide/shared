<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Agent extends Model
{
    /**
     * @return mixed
     */
    public function getTestimonials()
    {
        return json_decode($this->testimonials);

    }

    /**
     * @return string
     */
    public function fullName()
    {
        return trim(sprintf('%s %s', $this->first_name, $this->last_name));
    }

    /**
     * @return string
     */
    public function getPhotoPath()
    {
        return url(sprintf('/images/agents/%s', $this->photo_name));
    }

    /**
     * @return string
     */
    public function getLink()
    {
        return url(sprintf('/transition-experts/%s', $this->url_segment));
    }

    /**
     * @return HasMany
     */
    public function enquiries()
    {
        return $this->hasMany(AgentEnquiry::class);
    }
}
