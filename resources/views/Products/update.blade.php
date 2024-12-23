@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="my-4">Update Produk: {{ $product->nama_barang }}</h1>

        <!-- Form Update Produk -->
        <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <!-- Input Nama Barang -->
    <div class="form-group">
        <label for="nama_barang">Nama Barang:</label>
        <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="{{ old('nama_barang', $product->nama_barang) }}">
        @error('nama_barang')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <!-- Input Deskripsi Barang -->
    <div class="form-group">
        <label for="deskripsi_barang">Deskripsi Barang:</label>
        <textarea class="form-control" id="deskripsi_barang" name="deskripsi_barang">{{ old('deskripsi_barang', $product->deskripsi_barang) }}</textarea>
        @error('deskripsi_barang')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <!-- Input Harga Barang -->
    <div class="form-group">
        <label for="harga_barang">Harga Barang:</label>
        <input type="number" class="form-control" id="harga_barang" name="harga_barang" value="{{ old('harga_barang', $product->harga_barang) }}">
        @error('harga_barang')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <!-- Input Jumlah Barang -->
    <div class="form-group">
        <label for="jumlah_barang">Jumlah Barang:</label>
        <input type="number" class="form-control" id="jumlah_barang" name="jumlah_barang" value="{{ old('jumlah_barang', $product->jumlah_barang) }}">
        @error('jumlah_barang')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <!-- Input Tag Barang -->
    <div class="form-group">
        <label for="tag_barang">Tag Barang:</label>
        <input type="text" class="form-control" id="tag_barang" name="tag_barang" value="{{ old('tag_barang', $product->tag_barang) }}">
        @error('tag_barang')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <!-- Input Gambar Barang (Optional) -->
    <div class="form-group">
        <label for="gambar_barang">Gambar Barang (Optional):</label>
        <input type="file" class="form-control-file" id="gambar_barang" name="gambar_barang">
        @if ($product->gambar_barang)
            <div class="mt-2">
                <label>Gambar Saat Ini:</label>
                <img src="{{ Storage::url($product->gambar_barang) }}" alt="{{ $product->nama_barang }}" class="img-fluid" style="height: 200px; object-fit: cover;">
            </div>
        @endif
        @error('gambar_barang')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <!-- Submit Button -->
    <button type="submit" class="btn btn-primary mt-3">Update Produk</button>
</form>
    </div>
@endsection
