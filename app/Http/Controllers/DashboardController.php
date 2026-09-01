<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Project;
use App\Models\Skill;
use App\Models\Experience;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard', [
            'stats' => [
                'projects'        => Project::where('user_id', auth()->id())->count(),
                'skills'          => Skill::where('user_id', auth()->id())->count(),
                'experiences'     => Experience::where('user_id', auth()->id())->count(),
                'unread_messages' => Message::where('is_read', false)->count(),
                'total_messages'  => Message::count(),
            ],
        ]);
    }
}
