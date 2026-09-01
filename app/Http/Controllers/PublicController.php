<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;

class PublicController extends Controller
{
    public function index()
    {
        $user = User::with(['projects' => fn($q) => $q->where('status', 'published'), 'skills', 'experiences'])->first();

        return Inertia::render('Welcome', [
            'owner' => $user,
            'projects' => $user?->projects ?? collect(),
            'skills' => $user?->skills ?? collect(),
            'experiences' => $user?->experiences ?? collect(),
        ]);
    }
}
