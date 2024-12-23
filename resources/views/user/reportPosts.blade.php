@extends('layouts.app')

@section('title', 'Report Post')

@section('content')
<div class="container my-5">
    <h1 class="text-center mb-4">Report Post</h1>

    <!-- Menampilkan detail postingan -->
    <div class="row">
        <!-- Detail Postingan -->
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="post-info p-4 bg-light rounded shadow-sm">
                <h3 class="text-primary">{{ $post->user->username }}</h3>
                <p><strong>Content:</strong> {{ $post->content }}</p>
                <p><small class="text-muted">Posted {{ $post->created_at->diffForHumans() }}</small></p>

                @if($post->image_url)
                    <div class="post-image text-center mt-4">
                        <img src="{{ asset('storage/' . $post->image_url) }}" 
                             alt="Post Image" 
                             class="img-fluid rounded shadow-sm" 
                             style="max-width: 100%;">
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Form untuk laporan -->
    <div class="mt-5">
        <h3>Reason for Reporting</h3>
        <form action="{{ route('reports.post.submit', $post->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="reason">Reason:</label>
                <textarea name="reason" id="reason" class="form-control" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-danger mt-3">Submit Report</button>
        </form>
    </div>
</div>
@endsection
