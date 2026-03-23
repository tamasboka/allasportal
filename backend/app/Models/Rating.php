<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    public $table = 'ratings';
    public function rater() {
        return $this->belongsTo(User::class, 'rater_user_id');
    }
    public function rated() {
        return $this->belongsTo(User::class, 'rated_user_id');
    }
}
