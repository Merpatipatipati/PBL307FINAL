@extends('layouts.app')

@section('title', 'Daftar Percakapan')
<link href="{{ asset('css/home/conversation.css') }}" rel="stylesheet">
@section('content')
<div class="container conversation-container">
    <h1 class="conversation-title">Daftar Percakapan</h1>
    
    <div class="list-group mt-4 conversation-list">
        @foreach($conversations as $conversation)
            <a href="{{ route('message.show', $conversation->id) }}" class="list-group-item list-group-item-action conversation-item">
                <div class="conversation-header">
                    <strong>Percakapan dengan: 
                        @if($conversation->user1->id == auth()->id())
                            {{ $conversation->user2->username }} <!-- Menampilkan nama user2 jika user1 adalah yang sedang login -->
                        @else
                            {{ $conversation->user1->username }} <!-- Menampilkan nama user1 jika user2 adalah yang sedang login -->
                        @endif
                    </strong>
                    <p class="conversation-preview mb-0">Klik untuk melihat pesan</p>
                </div>
            </a>
        @endforeach
    </div>
</div>
@endsection