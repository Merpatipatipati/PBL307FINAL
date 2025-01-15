@extends('layouts.app')

@section('title', 'Search Results')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="{{ asset('css/home/dashboard.css') }}" rel="stylesheet">

<!-- Heading Halaman -->
<h2 class="text-center mb-4" style="color: #364360;">Search Results for: "{{ request()->query('query') }}"</h2>

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
                <h5 class="mb-3">Category</h5>
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

            <!-- Daftar Hasil Pencarian -->
            <div class="col-md-9">
                <!-- Menampilkan Pengguna -->
                @if($users->isNotEmpty())
                    <h4 class="mt-4">Users</h4>
                    <div class="row">
                        @foreach ($users as $user)
                            <div class="col-md-4 mb-4">
                                <div class="card user-card h-100 shadow-sm">
                                    <a href="{{ route('user.show', $user->id) }}" class="stretched-link"></a>
                                    <div class="card-body text-center">
                                        <!-- Foto Profil -->
                                        <img src="{{ Storage::url($user->photo) }}" alt="{{ $user->photo }}" class="img-fluid rounded-circle" style="height: 100px; width: 100px; object-fit: cover;">
                                        <h5 class="card-title mt-3">{{ $user->username }}</h5>
                                        <p class="card-text">{{ $user->fullname }}</p>
                                        <p class="card-text">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Menampilkan Produk -->
                @if($products->isNotEmpty())
                    <h4 class="mt-4">Products</h4>
                    <div class="row">
                        @foreach ($products as $product)
                            <div class="col-md-4 mb-4">
                                <div class="card product-card h-100 shadow-sm">
                                    <a href="{{ route('product.show', $product->id) }}" class="stretched-link"></a>
                                    <div class="product-image-wrapper">
                                        <img src="{{ Storage::url($product->gambar_barang) }}" alt="{{ $product->nama_barang }}" class="img-fluid" style="height: 200px; object-fit: cover;">
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title text-primary" title="{{ $product->nama_barang }}">
                                            {{ $product->nama_barang }}
                                        </h5>
                                        <p class="card-text">{{ \Str::limit($product->deskripsi_barang, 50, '...') }}</p>
                                        <p class="card-text font-weight-bold">
                                            <strong>Price:</strong> Rp {{ number_format($product->harga_barang, 2, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Menampilkan Postingan -->
                @if($posts->isNotEmpty())
                    <h4 class="mt-4">Posts</h4>
                    <div class="row">
                        @foreach ($posts as $post)
                            <div class="col-md-4 mb-4">
                                <div class="card post-card h-100 shadow-sm">
                                    <a href="{{ route('post.show', $post->id) }}" class="stretched-link"></a>
                                    <div class="card-body">
                                        <!-- Gambar Post -->
                                        <div class="post-image-wrapper">
                                            <img src="{{ Storage::url($post->image_url) }}" alt="{{ $post->title }}" class="img-fluid" style="height: 200px; object-fit: cover;">
                                        </div>
                                        <h5 class="card-title mt-3">{{ $post->title }}</h5>
                                        <p class="card-text">{{ \Str::limit($post->content, 50, '...') }}</p>
                                        <p class="card-text text-muted">
                                            <small>Posted by: {{ $post->user->username }}</small>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Pesan jika tidak ada hasil pencarian -->
                @if($products->isEmpty() && $posts->isEmpty() && $users->isEmpty())
                    <div class="col-12">
                        <div class="alert alert-warning" role="alert">
                            No results found for your search.
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</main>
@endsection
