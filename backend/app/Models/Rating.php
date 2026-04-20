<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    public $fillable = [
        'user_id',
        'job_id',
        'rating',
        'title',
        'message',
    ];
    public $table = 'ratings';
    public function rater() {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function rated() {
        return $this->belongsTo(Job::class, 'job_id');
    }
}
