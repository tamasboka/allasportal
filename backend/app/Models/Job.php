<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    public $table = 'jobs';

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
}
