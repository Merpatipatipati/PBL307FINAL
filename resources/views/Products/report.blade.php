@extends('layouts.app')

@section('title', 'Report Content')

@section('content')
<div class="container my-5">
    <h1 class="text-center mb-4">Report Content</h1>

    <!-- Menampilkan detail produk dan postingan -->
    <div class="row">
        <!-- Gambar Produk -->
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="product-image text-center">
                <h4 class="text-primary">Product</h4>
                <img src="{{ Storage::url($product->gambar_barang) }}" 
                     alt="{{ $product->nama_barang }}" 
                     class="img-fluid rounded shadow-sm mb-3" 
                     style="max-width: 100%; height: auto;">
                <p><strong>{{ $product->nama_barang }}</strong></p>
                <p>{{ $product->deskripsi_barang }}</p>
            </div>
        </div>

        <!-- Gambar Post -->
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="post-image text-center">
                <h4 class="text-primary">Post</h4>
                @if($post->image_url)
                    <img src="{{ Storage::url($post->image_url) }}" 
                         alt="Post Image" 
                         class="img-fluid rounded shadow-sm mb-3" 
                         style="max-width: 100%; height: auto;">
                @else
                    <p class="text-muted">No image attached to this post.</p>
                @endif
                <p><strong>Content:</strong> {{ $post->content }}</p>
            </div>
        </div>
    </div>

    <!-- Form untuk laporan -->
    <div class="mt-5">
        <h3>Reason for Reporting</h3>
        <form action="{{ route('reports.submit') }}" method="POST">
            @csrf
            <!-- Produk ID -->
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <!-- Post ID -->
            <input type="hidden" name="post_id" value="{{ $post->id }}">

            <!-- Input Alasan Laporan -->
            <div class="form-group">
                <label for="reason">Reason:</label>
                <textarea name="reason" id="reason" class="form-control" rows="4" placeholder="Explain why you are reporting this content..." required></textarea>
            </div>

            <!-- Tombol Submit -->
            <button type="submit" class="btn btn-danger mt-3">Submit Report</button>
        </form>
    </div>

    <!-- Tombol Pending -->
    <div class="mt-4 text-center">
        <button id="pendingButton" class="btn btn-warning">Pending</button>
    </div>
</div>

@endsection
