<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomSetting extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'welcome_message',
    ];
}
