<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportEmail extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'operator_id'
    ];

    /**
     * Get the operator that owns the report email.
     */
    public function operator()
    {
        return $this->belongsTo(Operator::class);
    }
}
