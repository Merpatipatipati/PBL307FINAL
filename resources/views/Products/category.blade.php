@extends('layouts.app')

@section('title', 'Halaman Utama')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="{{ asset('css/home/dashboard.css') }}" rel="stylesheet">

<!-- Heading Halaman -->
<h2 class="text-center mb-4" style="color: #364360;">Product List</h2>

<!-- SweetAlert Success Notification -->
@if (session('success'))
<script>
    document.addEventListener("DOMContentLoaded", function() {
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: "{{ session('success') }}",
            confirmButtonColor: '#364360',
        });
    });
</script>
@endif

<main>
    <div class="container mt-4">
        <div class="row">
            <!-- Sidebar Kategori -->
            <aside class="col-md-3">
                <h5 class="mb-3">Cetagory</h5>
                <div class="d-grid gap-2">
                    @foreach ([ 
                        ['All', 'fas fa-th-large'],
                        ['Electronics and Gadgets', 'fas fa-mobile-alt'],
                        ['Fashion', 'fas fa-tshirt'],
                        ['Health and Beauty', 'fas fa-heart'],
                        ['Food and Beverages', 'fas fa-utensils'],
                        ['Home Appliances', 'fas fa-blender'],
                        ['Furniture', 'fas fa-couch'],
                        ['Sports and Outdoor', 'fas fa-football-ball'],
                        ['Baby and Kids', 'fas fa-baby'],
                        ['Automotive', 'fas fa-car'],
                        ['School Supplies', 'fas fa-pen'],
                        ['Agriculture and Gardening', 'fas fa-seedling'],
                        ['Construction Supplies', 'fas fa-tools'],
                        ['More', 'fas fa-ellipsis-h']
                    ] as $category)
                    <div class="card border-light shadow-sm" style="height: 50px; width: 100%; font-size: 14px;">
                        <a href="{{ route('category', $category[0]) }}" class="stretched-link text-decoration-none text-dark">
                            <div class="card-body d-flex align-items-center">
                                <i class="{{ $category[1] }} fa-sm mr-2 text-primary"></i>
                                <span>{{ $category[0] }}</span>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </aside>

            <!-- Daftar Produk -->
            <div class="col-md-9">
                <div class="row">
                    @forelse ($products as $product)
                        <div class="col-md-4 mb-4">
                            <div class="card product-card h-100 shadow-sm">
                                <!-- Link ke halaman detail produk -->
                                <a href="{{ route('product.show', $product->id) }}" class="stretched-link"></a>
                                
                                <!-- Gambar Produk -->
                                <div class="product-image-wrapper">
                                    <img src="{{ Storage::url($product->gambar_barang) }}" alt="{{ $product->nama_barang }}" class="img-fluid">
                                </div>

                                <!-- Informasi Produk -->
                                <div class="card-body">
                                    <h5 class="card-title text-primary" title="{{ $product->nama_barang }}">
                                        {{ $product->nama_barang }}
                                    </h5>
                                    <p class="card-text" title="{{ $product->deskripsi_barang }}">
                                        {{ \Str::limit($product->deskripsi_barang, 50, '...') }}
                                    </p>
                                    <p class="card-text font-weight-bold">
                                        <strong>Price:</strong> Rp {{ number_format($product->harga_barang, 2, ',', '.') }}
                                    </p>
                                    <p class="card-text">
                                        <strong>Quantity:</strong> {{ $product->jumlah_barang }}
                                    </p>
                                    <p class="card-text">
                                        <strong>Cetagory:</strong> {{ $product->tag_barang }}
                                    </p>
                                    <p class="card-text text-muted">
                                        <small>Posted by: {{ $product->user->username }}</small>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-warning" role="alert">
                                No Product available.
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
