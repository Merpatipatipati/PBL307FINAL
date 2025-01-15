@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="text-dark font-weight-bold text-center mb-4">{{ $user->id === auth()->id() ? 'Your Posts' : 'Post by ' . $user->username }}</h2>

    @if($posts->isEmpty())
        <div class="alert alert-warning text-center">
            {{ $user->id === auth()->id() ? 'Anda belum membuat postingan.' : 'You dont have a post yet.' : 'This user has not made any posts.' }}
        </div>
    @else
        <div class="row">
            @foreach($posts as $post)
                <div class="col-md-6">
                    <div class="card mb-3 shadow-lg border-0 rounded-lg">
                        <div class="card-body">
                            <!-- Display post image if available -->
                            @if($post->image_url)
                                <img src="{{ asset('storage/' . $post->image_url) }}" 
                                     alt="Post Image" 
                                     class="img-fluid mb-3 rounded-lg" 
                                     style="height: 200px; object-fit: cover;">
                            @endif

                            <p class="font-italic">{{ $post->content }}</p>

                            <!-- Action buttons -->
                            <div class="d-flex justify-content-start mt-3">
                                <a href="{{ route('post.show', $post->id) }}" class="btn btn-primary btn-sm me-2" style="background-color: #364360; border-color: #364360;">Lihat Detail</a>
                                
                                <!-- Tampilkan tombol edit dan hapus hanya jika pemiliknya adalah user yang login -->
                                @if($user->id === auth()->id())
                                    <a href="{{ route('user.editPost', $post->id) }}" class="btn btn-warning btn-sm me-2">Edit</a>

                                    <form action="{{ route('user.deletePost', $post->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
