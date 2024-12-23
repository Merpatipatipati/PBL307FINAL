@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="text-dark font-weight-bold text-center mb-4">{{ $user->username }}'s Products</h2>

    @if($products->isEmpty())
        <div class="alert alert-warning text-center">This user hasn't uploaded any products yet.</div>
    @else
        <div class="row">
            @foreach($products as $product)
                <div class="col-md-4">
                    <div class="card mb-3 shadow-lg border-0 rounded-lg">
                        <div class="card-body">
                            <!-- Display product photo if available -->
                            @if($product->gambar_barang)
                                <img src="{{ Storage::url($product->gambar_barang) }}" 
                                     alt="{{ $product->nama_barang }}" 
                                     class="img-fluid mb-3 rounded-lg" 
                                     style="height: 200px; object-fit: cover;">
                            @endif

                            <h5 class="font-weight-bold">{{ $product->nama_barang }}</h5>
                            <p><strong>Price:</strong> Rp{{ number_format($product->harga_barang, 0, ',', '.') }}</p>
                            <p><strong>Tag:</strong> {{ $product->tag_barang }}</p>
                            <p><strong>Description:</strong> {{ $product->deskripsi_barang }}</p>
                            <p><strong>Stock:</strong> {{ $product->jumlah_barang }}</p>

                            <!-- Action buttons -->
                            <div class="d-flex justify-content-between mt-3">
                                <a href="{{ route('product.show', $product->id) }}" class="btn btn-primary btn-sm" style="background-color: #364360; border-color: #364360;">View Details</a>
                                @if(Auth::id() === $user->id)
                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
