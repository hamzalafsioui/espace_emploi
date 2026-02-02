<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = [
        'name',
    ];

    public function jobSeekers()
    {
        return $this->belongsToMany(JobSeeker::class, 'job_seeker_skill')->withPivot('level');
    }
}
