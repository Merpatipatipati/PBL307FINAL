@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Postingan {{ $user->id === auth()->id() ? 'Anda' : 'oleh ' . $user->username }}</h2>

    @if($posts->isEmpty())
        <p>{{ $user->id === auth()->id() ? 'You havent made a post yet.' : 'This user has not made any posts.' }}</p>
    @else
        <div class="row">
            @foreach($posts as $post)
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            @if($post->image_url)
                                <img src="{{ asset('storage/' . $post->image_url) }}" alt="Post Image" class="img-fluid mb-3">
                            @endif

                            <p><strong>Post Content:</strong></p>
                            <p>{{ $post->content }}</p>

                            <div class="d-flex justify-content-start mt-3">
                                <a href="{{ route('post.show', $post->id) }}" class="btn btn-primary btn-sm me-2">View Details</a>

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
