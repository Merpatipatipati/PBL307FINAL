@extends('layouts.app')

@section('title', 'Pesan Percakapan')
<!-- Link untuk CSS custom -->
<link href="{{ asset('css/home/message.css') }}" rel="stylesheet">
<script src="{{ asset('js/chat.js') }}"></script>

@section('content')
<div class="container">
    <!-- Menampilkan nama pengguna yang terlibat dalam percakapan -->
    <h1>Pesan dengan 
        {{ $conversation->user_id_1 == auth()->id() ? $conversation->user2->username : $conversation->user1->username }}
    </h1>
    
    <!-- Menampilkan pesan-pesan percakapan -->
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

    <!-- Formulir Kirim Pesan -->
    <form id="message-form" action="{{ route('message.send', $conversation->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <textarea name="content" id="message-content" class="form-control" rows="3" placeholder="Tulis pesan..." required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Kirim Pesan</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.3/dist/echo.iife.js"></script>
<script>
    Echo.channel('chat.{{ $conversation->id }}')
        .listen('MessageSent', (event) => {
            const messagesBox = document.getElementById('messages-box');
            const newMessage = event.message;

            // Menambahkan pesan baru ke dalam chat
            const messageDiv = document.createElement('div');
            messageDiv.classList.add('message-item', 'mb-3');
            messageDiv.setAttribute('data-message-id', newMessage.id);

            messageDiv.innerHTML = `
                <div class="${newMessage.sender_id == {{ auth()->id() }} ? 'text-right' : 'text-left'}">
                    <p class="mb-1"><strong>${newMessage.sender.username}</strong></p>
                    <p class="bg-light p-2 rounded d-inline-block" style="background-color: ${newMessage.sender_id == {{ auth()->id() }} ? '#007bff' : '#f8f9fa'}; color: black;">
                        ${newMessage.content}
                    </p>
                    <small class="text-muted d-block">${newMessage.sent_at}</small>
                </div>
            `;

            messagesBox.appendChild(messageDiv);
            messagesBox.scrollTop = messagesBox.scrollHeight; // Scroll otomatis ke bawah
        });
</script>
@endsection
