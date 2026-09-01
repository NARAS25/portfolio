<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
        'avatar', 'tagline', 'bio',
        'github_url', 'linkedin_url', 'instagram_url', 'cv_url',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function projects()
    {
        return $this->hasMany(Project::class)->orderBy('order');
    }

    public function skills()
    {
        return $this->hasMany(Skill::class)->orderBy('order');
    }

    public function experiences()
    {
        return $this->hasMany(Experience::class)->orderBy('order');
    }
}
