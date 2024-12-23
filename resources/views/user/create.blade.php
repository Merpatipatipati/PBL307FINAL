@extends('layouts.app')

@section('title', 'Buat Post Baru')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Buat Post Baru</h3>
                </div>
                <div class="card-body">
                    <!-- Menampilkan pesan error validasi -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Form untuk membuat post baru -->
                    <form action="{{ route('user.createPost') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="content" class="form-label">Konten</label>
                            <textarea 
                                class="form-control" 
                                id="content" 
                                name="content" 
                                rows="4" 
                                placeholder="Tulis sesuatu yang menarik..." 
                                required>{{ old('content') }}</textarea>
                        </div>

                        <div class="form-group mt-3">
                            <label for="image" class="form-label">Upload Gambar (Opsional)</label>
                            <input 
                                type="file" 
                                class="form-control-file" 
                                id="image" 
                                name="image" 
                                accept="image/*"
                                onchange="previewImage(event)">
                        
                            <!-- Tempat untuk menampilkan gambar preview -->
                            <div id="image-preview" class="mt-3">
                                <img id="preview" src="#" alt="Preview Gambar" style="display:none; width: 100%; max-width: 400px;">
                            </div>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">Unggah Post</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    // Fungsi untuk menampilkan preview gambar
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var preview = document.getElementById('preview');
            preview.src = reader.result;
            preview.style.display = 'block';  // Tampilkan gambar
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

@endsection

