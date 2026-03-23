<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    public $table = 'notifications';
    public function to() {
        return $this->belongsTo(User::class, 'to_user_id');
    }
    public function from() {
        return $this->belongsTo(User::class, 'from_user_id');
    }
}
