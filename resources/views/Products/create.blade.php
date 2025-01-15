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
    <select name="tag_barang" class="form-control" placeholder="choose the category" required>
        <option value="Electronics and Gadgets" {{ old('tag_barang') == 'Electronics and Gadgets' ? 'selected' : '' }}>Electronics and Gadgets</option>
        <option value="Fashion" {{ old('tag_barang') == 'Fashion' ? 'selected' : '' }}>Fashion</option>
        <option value="Health and Beauty" {{ old('tag_barang') == 'Health and Beauty' ? 'selected' : '' }}>Health and Beauty</option>
        <option value="Food and Beverages" {{ old('tag_barang') == 'Food and Beverages' ? 'selected' : '' }}>Food and Beverages</option>
        <option value="Home Appliances" {{ old('tag_barang') == 'Home Appliances' ? 'selected' : '' }}>Home Appliances</option>
        <option value="Furniture" {{ old('tag_barang') == 'Furniture' ? 'selected' : '' }}>Furniture</option>
        <option value="Sports and Outdoor" {{ old('tag_barang') == 'Sports and Outdoor' ? 'selected' : '' }}>Sports and Outdoor</option>
        <option value="Baby and Kids" {{ old('tag_barang') == 'Baby and Kids' ? 'selected' : '' }}>Baby and Kids</option>
        <option value="Automotive" {{ old('tag_barang') == 'Automotive' ? 'selected' : '' }}>Automotive</option>
        <option value="School Supplies" {{ old('tag_barang') == 'School Supplies' ? 'selected' : '' }}>School Supplies</option>
        <option value="Agriculture and Gardening" {{ old('tag_barang') == 'Agriculture and Gardening' ? 'selected' : '' }}>Agriculture and Gardening</option>
        <option value="Construction Supplies" {{ old('tag_barang') == 'Construction Supplies' ? 'selected' : '' }}>Construction Supplies</option>
        <option value="More" {{ old('tag_barang') == 'More' ? 'selected' : '' }}>More</option>
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
    <label for="gambar_barang">Upload (max 5MB)</label>
    <input type="file" name="gambar_barang" class="form-control" accept=".jpeg,.jpg,.png" id="imageInput" onchange="validateAndPreviewImage(event)">
    <div class="mt-3 text-center">
        <img id="imagePreview" src="" alt="Preview Gambar" style="max-width: 100%; max-height: 300px; display: none;">
    </div>
    <div id="error-message" style="color: red; display: none;" class="mt-2">File size exceeds 5MB. Please choose a smaller image.</div>
</div>

            <button type="submit" class="btn btn-primary btn-block">Upload</button>
        </form>
    </div>

<script>
function validateAndPreviewImage(event) {
    const fileInput = event.target;
    const file = fileInput.files[0];
    const errorMessage = document.getElementById("error-message");
    const imagePreview = document.getElementById("imagePreview");

    // Reset previous error message and preview
    errorMessage.style.display = "none";
    imagePreview.style.display = "none";

    // Check file size
    if (file && file.size > 5 * 1024 * 1024) { // 5 MB in bytes
        errorMessage.style.display = "block"; // Show error message
        fileInput.value = ''; // Clear the file input
        return;
    }

    // If file is valid, show the image preview
    const reader = new FileReader();
    reader.onload = function(e) {
        imagePreview.src = e.target.result;
        imagePreview.style.display = "block";
    }
    reader.readAsDataURL(file);
}
</script>
@endsection
