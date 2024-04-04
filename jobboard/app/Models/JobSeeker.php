<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobSeeker extends Model
{
    use HasFactory;
   
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'education',
        'title',
        'cnic',
        'dob',
        'address',
        'experience',
        'skills',
        'cv_path',
        'facebook_link',
        'twitter_link',
        'linkedin_link',
    ];
    public $timestamps = false;
    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function favorites()
    {
        return $this->belongsToMany(Job::class, 'favorites');
    }
    
}
