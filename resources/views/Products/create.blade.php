@extends('layouts.app')

@section('title', 'Upload Barang')
<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@section('content')
    <div class="container mt-5">
        <h2 class="text-center mb-4">Upload Item</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="nama_barang">Product Name</label>
                <input type="text" name="nama_barang" class="form-control" placeholder="Enter the Item Name" required value="{{ old('nama_barang') }}">
            </div>

            <div class="form-group">
                <label for="tag_barang">Category</label>
                <select name="tag_barang" class="form-control" required>
                    <option value="">Select Category</option>
                    <option value="Electronics and Gadgets" {{ old('tag_barang') == 'Electronics and Gadgets' ? 'selected' : '' }}>Electronics</option>
                    <!-- Add more options as needed -->
                </select>
            </div>

            <div class="form-group">
                <label for="harga_barang">Price (Rp)</label>
                <input type="number" name="harga_barang" class="form-control" placeholder="Enter the Item Price" required value="{{ old('harga_barang') }}">
            </div>

            <div class="form-group">
                <label for="jumlah_barang">Quantity</label>
                <input type="number" name="jumlah_barang" class="form-control" placeholder="Enter the number of items"
                    required id="jumlah_barang" oninput="validateQuantity(this)" value="{{ old('jumlah_barang') }}">
                <small id="quantityError" class="text-danger" style="display: none;">Quantity must be between 1 and 100.</small>
            </div>

            <div class="form-group">
                <label for="deskripsi_barang">Description</label>
                <textarea name="deskripsi_barang" class="form-control" rows="4" placeholder="Enter an Item Description">{{ old('deskripsi_barang') }}</textarea>
            </div>

            <div class="form-group">
                <label for="gambar_barang">Upload</label>
                <input type="file" name="gambar_barang" class="form-control" accept="image/*" id="imageInput" onchange="previewImage(event)">
                <div class="mt-3 text-center">
                    <img id="imagePreview" src="" alt="Preview Gambar" style="max-width: 100%; max-height: 300px; display: none;">
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Upload</button>
        </form>
    </div>

    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                const imagePreview = document.getElementById('imagePreview');
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block';
            };

            if (file) {
                reader.readAsDataURL(file);
            }
        }

        // SweetAlert for success message
        @if(session('productUploaded'))
            Swal.fire({
                title: 'Barang Berhasil Diupload!',
                text: 'Barang baru Anda telah berhasil diunggah.',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        @endif
    </script>
@endsection
