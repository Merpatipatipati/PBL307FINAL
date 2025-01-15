@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Edit Post</h2>

    <form action="{{ route('user.updatePost', $post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="content" class="form-label">Konten</label>
            <textarea name="content" id="content" class="form-control" rows="4" required>{{ old('content', $post->content) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Post image</label>
            @if($post->image_url)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $post->image_url) }}" alt="Current Image" class="img-fluid" width="100">
                </div>
            @endif
            <input type="file" name="image" id="image" class="form-control" onchange="previewImage(event)">
            <div id="image-preview-container" class="mt-2"></div>
        </div>

        <button type="submit" class="btn btn-primary">Save update</button>
    </form>

    <a href="{{ route('user.allPost', ['id' => auth()->id()]) }}" class="btn btn-secondary mt-3">back</a>

</div>

<script>
    function previewImage(event) {
        const previewContainer = document.getElementById('image-preview-container');
        const file = event.target.files[0];

        // Hapus gambar preview sebelumnya
        previewContainer.innerHTML = '';

        // Jika file dipilih dan itu adalah gambar
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('img-fluid');
                img.width = 100; // Atur ukuran gambar
                previewContainer.appendChild(img);
            };

            reader.readAsDataURL(file);
        } else {
            previewContainer.innerHTML = '<p class="text-danger">Harap pilih gambar yang valid.</p>';
        }
    }
</script>

@endsection
