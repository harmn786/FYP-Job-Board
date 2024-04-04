<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    // public $timestamps = false;
    use HasFactory;
    public function employer()
    {
        return $this->belongsTo(Employer::class);
    }

    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class);
    }
    protected $fillable = [
        'title',
        'type',
        'vacancy',
        'salary',
        'education',
        'experience',
        'location',
        'gender',
        'application_deadline',
        'description',
        'other_requirements',
        'other_benifits',
        'company_name',
        'company_email',
        'category',
        'featured',
        'company_image',
        'employer_id',
        'approved_by_admin',
        
    ];

    public function favorite()
    {
        return $this->belongsTo(Favorite::class);
    }
}
