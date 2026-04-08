<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    public $fillable = [
        "user_id",
        "job_id",
        "message"
    ];
    public $table = 'job_applications';
    public function sender()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function receiver()
    {
        return $this->belongsTo(Job::class, 'job_id', 'id');
    }
}
