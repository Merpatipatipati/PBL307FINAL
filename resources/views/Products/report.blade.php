@extends('layouts.app')

@section('title', 'Report Content')

@section('content')
<div class="container my-5">
    <h1 class="text-center mb-4">Report Content</h1>

    <!-- Menampilkan detail produk -->
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 mb-4">
            <div class="product-details text-center p-4 shadow-sm rounded border">
                <h4 class="text-primary mb-3">Product Details</h4>
                <!-- Gambar Produk -->
                <img src="{{ Storage::url($product->gambar_barang) }}"
                     alt="{{ $product->nama_barang }}"
                     class="img-fluid rounded shadow-sm mb-3"
                     style="max-width: 100%; height: auto;">
                
                <!-- Informasi Produk -->
                <h5><strong>{{ $product->nama_barang }}</strong></h5>
                <p class="text-muted">{{ $product->deskripsi_barang }}</p>
                <p><strong>Harga:</strong> Rp {{ number_format($product->harga_barang, 2, ',', '.') }}</p>
                <p><strong>Jumlah:</strong> {{ $product->jumlah_barang }}</p>
                <p><strong>Tag:</strong> {{ $product->tag_barang }}</p>
            </div>
        </div>
    </div>

    <!-- Form untuk laporan -->
    <div class="row justify-content-center mt-5">
        <div class="col-lg-6 col-md-8">
            <div class="report-form p-4 shadow-sm rounded border">
                <h3 class="text-center text-danger mb-4">Reason for Reporting</h3>
                <form action="{{ route('reports.product.submit', ['reportId' => $product->id, 'reportType' => 'product']) }}" method="POST">
                    @csrf
                    <!-- Produk ID -->
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    <!-- Input Alasan Laporan -->
                    <div class="form-group">
                        <label for="reason">Reason:</label>
                        <textarea name="reason" id="reason" class="form-control" rows="4" placeholder="Explain why you are reporting this content..." required></textarea>
                    </div>

                    <!-- Tombol Submit -->
                    <button type="submit" class="btn btn-danger mt-3 w-100">Submit Report</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

