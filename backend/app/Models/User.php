<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    public $table = 'users';

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'gender',
        'birthdate',
        'phone',
        'work_experience',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function workplaces()
    {
        return $this->belongsToMany(Job::class);
    }

    public function saved_jobs()
    {
        return $this->belongsToMany(Job::class, 'user_saved_jobs', 'user_id', 'job_id');
    }

    public function published_jobs()
    {
        return $this->hasMany(Job::class);
    }

    /*public function sent_notifications()
    {
        return $this->hasMany(Notification::class, 'from_user_id');
    }*/

    public function received_notifications()
    {
        return $this->hasMany(Notification::class, 'to_user_id');
    }
    public function sent_ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class);
    }
}
