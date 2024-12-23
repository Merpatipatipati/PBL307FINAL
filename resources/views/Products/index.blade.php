@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="my-4">Daftar Produk</h1>

        <div class="row">
            <!-- Sidebar Kategori -->
            <aside class="col-md-3">
                <h5>Kategori</h5>
                <ul class="list-group">
                    <li class="list-group-item"><a href="{{ route('category', 'Electronics and Gadgets') }}">Electronics and Gadgets</a></li>
                    <li class="list-group-item"><a href="{{ route('category', 'Fashion') }}">Fashion</a></li>
                    <li class="list-group-item"><a href="{{ route('category', 'Health and Beauty') }}">Health and Beauty</a></li>
                    <li class="list-group-item"><a href="{{ route('category', 'Food and Beverages') }}">Food and Beverages</a></li>
                    <li class="list-group-item"><a href="{{ route('category', 'Home Appliances') }}">Home Appliances</a></li>
                    <li class="list-group-item"><a href="{{ route('category', 'Furniture') }}">Furniture</a></li>
                    <li class="list-group-item"><a href="{{ route('category', 'Sports and Outdoor') }}">Sports and Outdoor</a></li>
                    <li class="list-group-item"><a href="{{ route('category', 'Baby and Kids') }}">Baby and Kids</a></li>
                    <li class="list-group-item"><a href="{{ route('category', 'Automotive') }}">Automotive</a></li>
                    <li class="list-group-item"><a href="{{ route('category', 'Office and School Supplies') }}">Office and School Supplies</a></li>
                    <li class="list-group-item"><a href="{{ route('category', 'Agriculture and Gardening') }}">Agriculture and Gardening</a></li>
                    <li class="list-group-item"><a href="{{ route('category', 'Real Estate and Construction Supplies') }}">Real Estate and Construction Supplies</a></li>
                </ul>
            </aside>

            <!-- Product Listings -->
            <main class="col-md-9">
        @forelse ($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <!-- Link ke halaman detail produk -->
                    <a href="{{ route('product.show', $product->id) }}" class="stretched-link"></a>
                    
                    <!-- Gambar Produk -->
                    <img src="{{ Storage::url($product->gambar_barang) }}" alt="{{ $product->nama_barang }}" class="img-fluid" style="height: 200px; object-fit: cover;">
                    
                    <div class="card-body">
                        <h5 class="card-title text-primary">{{ $product->nama_barang }}</h5>
                        <p class="card-text">{{ $product->deskripsi_barang }}</p>
                        <p class="card-text"><strong>Harga:</strong> Rp {{ number_format($product->harga_barang, 2, ',', '.') }}</p>
                        <p class="card-text"><strong>Jumlah:</strong> {{ $product->jumlah_barang }}</p>
                        <p class="card-text"><strong>Tag:</strong> {{ $product->tag_barang }}</p>
                        <p class="card-text"><small class="text-muted">Di-upload oleh: {{ $product->user->username }}</small></p>
                    </div>
                </div>
            </div>
                    @endforeach
                </div>

                <!-- Jika Tidak Ada Produk -->
                @if($products->isEmpty())
                    <p class="alert alert-warning">Tidak ada produk yang ditemukan.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
