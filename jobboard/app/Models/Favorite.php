<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;
    public function jobSeeker()
    {
        return $this->belongsTo(JobSeeker::class);
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}
