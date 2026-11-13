<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'number' => 'required|string|max:20',
            'message' => 'required|string|max:1000',
        ]);

        $userId = Auth::check() ? Auth::id() : null;

        Message::create([
            'user_id' => $userId,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'number' => $validated['number'],
            'message' => $validated['message'],
        ]);

        return back()->with('success', 'Pesan Anda telah berhasil terkirim. Terima kasih atas masukan Anda!');
    }
}
