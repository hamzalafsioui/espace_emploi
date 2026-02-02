<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'job_offer_id',
        'job_seeker_id',
        'status',
        'message',
    ];

    public function jobOffer()
    {
        return $this->belongsTo(JobOffer::class);
    }

    public function jobSeeker()
    {
        return $this->belongsTo(JobSeeker::class);
    }
}
