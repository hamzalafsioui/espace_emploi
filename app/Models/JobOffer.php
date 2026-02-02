<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobOffer extends Model
{
    protected $fillable = [
        'recruiter_id',
        'title',
        'description',
        'company_name',
        'location',
        'contract_type',
        'image_path',
        'status',
    ];

    public function recruiter()
    {
        return $this->belongsTo(Recruiter::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
