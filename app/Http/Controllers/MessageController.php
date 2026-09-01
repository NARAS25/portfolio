<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Inertia\Inertia;

class MessageController extends Controller
{
    public function index()
    {
        return Inertia::render('Messages/Index', [
            'messages' => Message::latest()->get(),
        ]);
    }

    public function markRead(Message $message)
    {
        $message->update(['is_read' => true]);

        return back()->with('success', 'Pesan ditandai sudah dibaca.');
    }

    public function destroy(Message $message)
    {
        $message->delete();

        return back()->with('success', 'Pesan berhasil dihapus!');
    }
}
