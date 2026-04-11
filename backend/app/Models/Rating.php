<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    public $table = 'ratings';
    public function rater() {
        return $this->belongsTo(User::class);
    }
    public function rated() {
        return $this->belongsTo(Job::class);
    }
}
