<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{
    use HasFactory;
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function jobs()
    {
        return $this->hasMany(Job::class);
    }
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'industry',
        'contact_person',
        'contact_number',
    ];
    public $timestamps = false;
}
