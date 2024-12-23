@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Semua Barang Anda</h2>

    @if($products->isEmpty())
        <p>Anda belum mengunggah barang.</p>
    @else
        <div class="row">
            @foreach($products as $product)
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <!-- Display product photo if available -->
                            @if($product->gambar_barang)
                                <img src="{{ Storage::url($product->gambar_barang) }}" 
                                     alt="{{ $product->nama_barang }}" 
                                     class="img-fluid mb-2" 
                                     style="height: 200px; object-fit: cover;">
                            @endif

                            <h5>{{ $product->nama_barang }}</h5>
                            <p><strong>Harga:</strong> Rp{{ number_format($product->harga_barang, 0, ',', '.') }}</p>
                            <p><strong>Tag:</strong> {{ $product->tag_barang }}</p>
                            <p><strong>Deskripsi:</strong> {{ $product->deskripsi_barang }}</p>
                            <p><strong>Jumlah:</strong> {{ $product->jumlah_barang }}</p>

                            <!-- Action buttons -->
                            <a href="{{ route('product.show', $product->id) }}" class="btn btn-primary btn-sm">Lihat Detail</a>
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

