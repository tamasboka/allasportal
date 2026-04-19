<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    public $table = 'jobs';
    public $fillable = [
        'name',
        'description',
        'min_salary',
        'max_salary',
        'capacity',
        'has_home_office',
        'job_type',
        'type',
        'location',
        'currency',
        'user_id'
    ];

    public function owner()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
    public function required_skills()
    {
        return $this->belongsToMany(Skill::class);
    }
    public function received_applications() {
        return $this->hasMany(JobApplication::class, 'job_id', 'id');
    }
    public function ratings() {
        return $this->hasMany(Rating::class, 'job_id', 'id');
    }
    public function workers() {
        return $this->belongsToMany(User::class);
    }
    public $casts = [
        'has_home_office' => 'boolean',
    ];
}
