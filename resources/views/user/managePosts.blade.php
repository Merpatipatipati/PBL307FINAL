@extends('layouts.app')

@section('title', 'Post List')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<link href="{{ asset('css/home/managepost.css') }}" rel="stylesheet">
<script src="{{ asset('js/managepost.js') }}"></script>

@section('content')
<div class="container mt-4">
    <div class="mb-4 text-center">
        <h1 class="display-5">Post List</h1>
        <p class="text-muted">Lihat apa yang diposting pengguna lain!</p>
    </div>

    <!-- Menampilkan daftar postingan -->
    @if($posts->isEmpty())
        <div class="alert alert-info text-center">
            <p>Belum ada postingan dari pengguna.</p>
        </div>
    @else
        <div class="row justify-content-center">
            @foreach($posts as $post)
                <div class="col-md-8 mb-4">
                    <div class="card shadow border-0">
                        <div class="card-header bg-white border-0 d-flex align-items-center">
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
                            <p class="card-text text-dark">{{ $post->content }}</p>

                            @if($post->image_url)
                                <img 
                                    src="{{ asset('storage/' . $post->image_url) }}" 
                                    alt="Gambar Postingan" 
                                    class="img-fluid rounded mt-3 shadow-sm">
                            @endif
                        </div>

                        <div class="card-footer bg-white d-flex justify-content-between align-items-center">
                            <div class="d-flex">
                                <button class="btn btn-sm btn-outline-primary me-2" data-bs-toggle="collapse" data-bs-target="#comment-section-{{ $post->id }}">
                                    Komentar
                                </button>
                                <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#postDetailModal{{ $post->id }}">Detail</button>
                            </div>
                        </div>

                        <!-- Section Komentar -->
                        <div id="comment-section-{{ $post->id }}" class="collapse mt-3">
                            <!-- Form Komentar -->
                            <div class="comment-form mt-4">
                                <form method="POST" action="{{ route('comments.post', $post->id) }}">
                                    @csrf
                                    <textarea name="content" id="comment-content-{{ $post->id }}" class="form-control" rows="3" required placeholder="Tulis komentar..."></textarea>
                                    <button type="submit" class="btn btn-success mt-2">Kirim Komentar</button>
                                </form>
                            </div>

                            <!-- Bagian Menampilkan Komentar -->
                            <div class="comments-section mt-5">
                                <h3>Komentar:</h3>
                                <div id="comments-container-{{ $post->id }}">
                                    @foreach ($post->comments as $comment)
                                        @if($comment->user && !$comment->user->is_banned) <!-- Check if comment's user is not banned -->
                                            <div class="comment-item mb-3 border-bottom pb-2" id="comment-{{ $comment->id }}">
                                                <p><strong>{{ $comment->user->username }}</strong></p>
                                                <p>{{ $comment->content }}</p>
                                                <small class="text-muted">{{ $comment->created_at->format('d-m-Y H:i') }}</small>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- Modal Detail Post -->
@foreach($posts as $post)
    @if(!$post->user->is_banned)  <!-- Check if the user is not banned -->
        <div class="modal fade" id="postDetailModal{{ $post->id }}" tabindex="-1" aria-labelledby="postDetailModalLabel{{ $post->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="postDetailModalLabel{{ $post->id }}">Detail Postingan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h5>{{ $post->user->username }}</h5>
                        <p>{{ $post->content }}</p>

                        @if($post->image_url)
                            <img 
                                src="{{ asset('storage/' . $post->image_url) }}" 
                                alt="Gambar Postingan" 
                                class="img-fluid rounded mt-3 shadow-sm">
                        @endif

                        <!-- Chat dan Report Fitur -->
                        <div class="mt-3">
                            @if(auth()->user()->id == $post->user_id)
                                <!-- Hanya tampilkan Edit dan Delete untuk yang memiliki post -->
                                <a href="{{ route('user.editPost', $post->id) }}" class="btn btn-sm btn-outline-primary me-2">Edit</a>
                                <form action="{{ route('user.deletePost', $post->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus postingan ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            @else
                                <!-- Tampilkan Chat dan Report untuk pengguna lain -->
                                <a href="{{ route('chat.user', $post->user->id) }}" class="btn btn-sm btn-outline-warning me-2">
                                    Chat
                                </a>
                                <a href="{{ route('reports.post.show', $post->id) }}" class="btn btn-sm btn-outline-danger">
                                    Report
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach

@endsection
