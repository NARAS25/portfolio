<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Models\Message;

class ContactController extends Controller
{
    public function store(StoreContactRequest $request)
    {
        Message::create($request->validated());

        return back()->with('success', 'Pesan berhasil dikirim! Saya akan segera membalas.');
    }
}
