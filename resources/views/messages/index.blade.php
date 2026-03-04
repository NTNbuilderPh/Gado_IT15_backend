@extends('layouts.app')
@section('title', 'Messages')

@section('content')
<div class="messages-page">
    <div class="page-header">
        <h1>Messages</h1>
        <p>Send messages to faculty and view notifications</p>
    </div>

    <div class="grid-two-col">
        {{-- Compose --}}
        <div class="card">
            <div class="card-header"><h2>Send Message to Faculty</h2></div>
            <form method="POST" action="{{ route('messages.store') }}">
                @csrf
                <div class="form-group">
                    <label for="receiver_email">Faculty Email</label>
                    <input type="email" id="receiver_email" name="receiver_email"
                           placeholder="professor@um.edu.ph" required>
                </div>
                <div class="form-group">
                    <label for="subject">Subject</label>
                    <input type="text" id="subject" name="subject" placeholder="Message subject" required>
                </div>
                <div class="form-group">
                    <label for="body">Message</label>
                    <textarea id="body" name="body" rows="5" placeholder="Type your message..." required></textarea>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Send Message</button>
            </form>
        </div>

        {{-- Inbox --}}
        <div class="card">
            <div class="card-header"><h2>Inbox</h2></div>
            @if($messages->count() > 0)
            <div class="message-list">
                @foreach($messages as $message)
                <div class="message-item {{ $message->is_read ? '' : 'unread' }}">
                    <div class="message-header">
                        <strong>{{ $message->subject }}</strong>
                        <small>{{ $message->created_at->diffForHumans() }}</small>
                    </div>
                    <div class="message-type">
                        <span class="badge badge-{{ $message->type === 'welcome' ? 'success' : 'neutral' }}">
                            {{ ucfirst(str_replace('_', ' ', $message->type)) }}
                        </span>
                    </div>
                    <p class="message-body">{{ Str::limit($message->body, 150) }}</p>
                </div>
                @endforeach
            </div>
            {{ $messages->links() }}
            @else
            <div class="empty-state"><p>No messages yet.</p></div>
            @endif
        </div>
    </div>
</div>
@endsection