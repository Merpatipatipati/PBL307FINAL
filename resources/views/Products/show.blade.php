@extends('layouts.app')
<link href="{{ asset('css/home/showproduct.css') }}" rel="stylesheet">
<script src="{{ asset('js/showproduct.js') }}"></script>

@section('content')
<div class="container my-5">
    <!-- Judul Produk -->
    <h1 class="my-4 text-center text-uppercase font-weight-bold">{{ $product->nama_barang }}</h1>
    
    <div class="row">
        <!-- Menampilkan gambar produk di sebelah kiri -->
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="product-image">
                <img src="{{ Storage::url($product->gambar_barang) }}" alt="{{ $product->nama_barang }}" class="img-fluid rounded shadow-sm">
            </div>
        </div>

        <!-- Menampilkan informasi produk di sebelah kanan -->
        <div class="col-lg-6 col-md-12">
            <div class="product-info p-4 bg-light rounded shadow-sm">
                <!-- Pengelompokan Informasi Produk -->
                <div class="product-details mb-4">
                    <h3 class="text-primary">Product Information</h3>
                    <p><strong>Description:</strong> {{ $product->deskripsi_barang }}</p>
                    <p><strong>Price:</strong> Rp {{ number_format($product->harga_barang, 2, ',', '.') }}</p>
                    <p><strong>Quantity:</strong> {{ $product->jumlah_barang }}</p>
                    <p><strong>Category:</strong> {{ $product->tag_barang }}</p>
                    <p><small class="text-muted">uploaded by: {{ $product->user->username }}</small></p>
                </div>

                <!-- Tombol untuk pemilik produk (Edit, Hapus) -->
                @if($canUpdate || $canDelete)
                    @if($canUpdate)
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary flex-fill mx-1">
                            <i class="fas fa-edit mr-1"></i> Edit Product
                        </a>
                    @endif
                    @if($canDelete)
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger flex-fill mx-1">Delete Product</button>
                        </form>
                    @endif
                @endif

                <!-- Tombol untuk chat dan report hanya untuk pengguna lain -->
                @if(auth()->user()->id !== $product->user_id)
                    <div class="mt-4 btn-group d-flex justify-content-between">
                        <a href="{{ route('message.start', $product->user_id) }}" class="btn btn-primary flex-fill mx-1">Chat dengan Penjual</a>
                        <a href="{{ route('reports.product.form', $product->id) }}" class="btn btn-danger flex-fill mx-1">Laporkan Produk</a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Form Komentar -->
    <div class="comment-form mt-4">
        <form id="comment-form" method="POST" action="{{ route('product.storeComment', $product->id) }}">
            @csrf
            <textarea name="content" id="comment-content" class="form-control" rows="3" required></textarea>
            <button type="submit" class="btn btn-success mt-2">Send Comments</button>
        </form>
    </div>

    <!-- Bagian Menampilkan Komentar -->
    <div class="comments-section mt-5">
        <h3>Comments:</h3>
        <div id="comments-container">
            @foreach ($comments as $comment)
                <div class="comment-item mb-3 border-bottom pb-2">
                    <p><strong>{{ $comment->user->username }}</strong></p>
                    <p>{{ $comment->content }}</p>
                    <small class="text-muted">{{ $comment->created_at->format('d-m-Y H:i') }}</small>

                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
