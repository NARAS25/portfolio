<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'slug', 'description', 'content',
        'thumbnail', 'tech_stack', 'github_url', 'demo_url', 'status', 'order',
    ];

    protected $casts = [
        'tech_stack' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
