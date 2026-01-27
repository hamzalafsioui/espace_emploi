<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobSeeker extends Model
{
    protected $fillable = [
        'user_id',
        'specialty',
        'experience_level',
        'skills',
        'cv_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
