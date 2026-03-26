<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    public $table = 'organizations';
    public $fillable = [
        'name',
        'founded_at'
    ];

    public function workers()
    {
        return $this->belongsToMany(User::class);
    }
    public function jobs() {
        return $this->hasMany(Job::class);
    }
}
