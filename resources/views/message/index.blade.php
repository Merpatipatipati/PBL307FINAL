@extends('layouts.app')

@section('title', 'Daftar Percakapan')
<link href="{{ asset('css/home/conversation.css') }}" rel="stylesheet">
@section('content')
<div class="container conversation-container">
    <h1 class="conversation-title">Conversation List</h1>
    
    <div class="list-group mt-4 conversation-list">
        @foreach($conversations as $conversation)
            <a href="{{ route('message.show', $conversation->id) }}" class="list-group-item list-group-item-action conversation-item">
                <div class="conversation-header">
                    <strong>Conversation with 
                        @if($conversation->user1->id == auth()->id())
                            {{ $conversation->user2->username }} 
                        @else
                            {{ $conversation->user1->username }} 
                        @endif
                    </strong>
                    <p class="conversation-preview mb-0">Click to view message</p>
                </div>
            </a>
        @endforeach
    </div>
</div>
@endsection
