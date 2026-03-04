<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $student  = Auth::user();
        $messages = Message::where('sender_id', $student->id)
            ->orWhere('receiver_email', $student->email)
            ->latest()
            ->paginate(15);

        return view('messages.index', compact('student', 'messages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'receiver_email' => 'required|email',
            'subject'        => 'required|string|max:255',
            'body'           => 'required|string|max:5000',
        ]);

        Message::create([
            'sender_id'      => Auth::id(),
            'receiver_email' => $request->receiver_email,
            'subject'        => $request->subject,
            'body'           => $request->body,
            'type'           => 'student_to_faculty',
        ]);

        return back()->with('success', 'Message sent successfully!');
    }
}