<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgentEnquiry extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'agent_id',
        'name',
        'email',
        'phone',
        'address',
        'subject',
        'message',
    ];

    /**
     * Get the agent that owns the enquiry.
     */
    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }
}
