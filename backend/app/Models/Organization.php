<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    public $table = 'organizations';
    public function workers() {
        return $this->hasMany(User::class);
    }
}
