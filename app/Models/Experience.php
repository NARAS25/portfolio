<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'type', 'title', 'organization', 'location',
        'description', 'start_date', 'end_date', 'is_current', 'order',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
        'is_current' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
