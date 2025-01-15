@extends('layouts.app')
@section('title', 'Pesan Percakapan')
<script src="https://cdn.socket.io/4.5.0/socket.io.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.4/dist/echo.iife.js"></script>
<script src="{{ mix('js/chat.js') }}"></script>
<script src="{{ mix('js/index.js') }}"></script>

@section('content')
<div class="container">
    <!-- Menambahkan #chat-data dengan atribut yang diperlukan -->
    <div id="chat-data"
         data-username="{{ auth()->user()->username }}" 
         data-conversation-id="{{ $conversation->id }}" 
         data-user-id="{{ auth()->id() }}">
    </div>

    <h1>Pesan dengan
        {{ $conversation->user_id_1 == auth()->id() ? $conversation->user2->username : $conversation->user1->username }}
    </h1>

<div id="messages-box" class="messages-box my-4 p-3 border rounded" style="max-height: 400px; overflow-y: scroll;">
    @foreach($messages as $message)
        <div class="message-item mb-3" data-message-id="{{ $message->id }}">
            <div class="{{ $message->sender_id == auth()->id() ? 'text-right' : 'text-left' }}">
                <p class="mb-1">
                    <strong>
                        {{ $message->sender ? $message->sender->username : 'Pengguna tidak ditemukan' }}
                    </strong>
                </p>
                <p class="bg-light p-2 rounded d-inline-block" style="background-color: {{ $message->sender_id == auth()->id() ? '#007bff' : '#f8f9fa' }}; color: black;">
                    {{ $message->content }}
                </p>
                <small class="text-muted d-block">{{ $message->sent_at->format('H:i d-m-Y') }}</small>
            </div>
        </div>
    @endforeach
</div>
    <form id="message-form">
        <div class="form-group">
            <textarea name="content" id="message-content" class="form-control" rows="3" placeholder="Tulis pesan..." required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Send Message</button>
    </form>
</div>
@endsection

