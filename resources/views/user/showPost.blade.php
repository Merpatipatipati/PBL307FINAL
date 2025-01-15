@extends('layouts.app')

@section('title', 'Post Detail')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 mb-4">
            <div class="card shadow border-0">
                <div class="card-header bg-white border-0 d-flex align-items-center">
                    <!-- User Profile and Info -->
                    <img 
                        src="{{ asset('storage/' . ($post->user->photo ?? 'default_profile.jpg')) }}" 
                        alt="Foto Profil" 
                        class="rounded-circle me-3 shadow-sm" 
                        width="50" height="50">
                    <div>
                        <h5 class="mb-0 fw-bold">{{ $post->user->username }}</h5>
                        <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                    </div>
                </div>

                <div class="card-body">
                    <h4 class="card-title">{{ $post->title }}</h4>
                    <p class="card-text text-dark">{{ $post->content }}</p>

                    <!-- Post Image -->
                    @if($post->image_url)
                        <img 
                            src="{{ asset('storage/' . $post->image_url) }}" 
                            alt="Gambar Postingan" 
                            class="img-fluid rounded mt-3 shadow-sm">
                    @endif
                </div>

                <div class="card-footer bg-white d-flex justify-content-between align-items-center">

                    <!-- Action Buttons for Post Owner or Other Users -->
                    <div class="d-flex">
                        <!-- If the logged-in user is the post owner -->
                        @if(Auth::check() && Auth::user()->id == $post->user_id)
                            <a href="{{ route('user.editPost', $post->id) }}" class="btn btn-sm btn-outline-warning me-2">Edit Post</a>

                            <form action="{{ route('user.deletePost', $post->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete Post</button>
                            </form>
                        @else
                            <!-- If the logged-in user is not the post owner -->
                            <a href="{{ route('chat.user', $post->user->id) }}" class="btn btn-sm btn-outline-info me-2">Chat Pengguna</a>
                            <form action="{{ route('reports.post.show', ['id' => $post->id]) }}" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger">
                                    Report Post
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                <!-- Section for Comments -->
                <div class="mt-4">
                    <h5>Comments:</h5>

                    <!-- Form to Add Comment -->
                    <div class="comment-form">
                        <form method="POST" action="{{ route('comments.post', $post->id) }}">
                            @csrf
                            <textarea name="content" id="comment-content" class="form-control" rows="3" required placeholder="Tulis komentar..."></textarea>
                            <button type="submit" class="btn btn-success mt-2">send comments</button>
                        </form>
                    </div>

                    <!-- Displaying Existing Comments -->
                    <div class="comments-section mt-3">
                        @foreach ($post->comments as $comment)
                            <div class="comment-item mb-3 border-bottom pb-2">

<p><strong>{{ $comment->user ? $comment->user->username : 'Anonymous' }}</strong></p>
                                <p>{{ $comment->content }}</p>
                                <small class="text-muted">{{ $comment->created_at->format('d-m-Y H:i') }}</small>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
