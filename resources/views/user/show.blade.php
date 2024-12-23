@extends('layouts.app')

@push('styles')
<link href="{{ asset('css/home/user.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container mt-5">
    <!-- Dynamic Title -->
    <h2 class="text-center mb-4 text-dark font-weight-bold">Welcome to {{ $user->username }}'s Profile</h2>

    <!-- Profile Photo Section (Centered) -->
    <div class="d-flex justify-content-center mb-5">
    <div class="text-center">
                <div class="profile-photo-container">
                    <img src="{{ Storage::url($user->photo) }}" alt="{{ $user->photo }}" 
                         alt="User Profile Photo" 
                         class="rounded-circle border shadow-lg" 
                         width="120" 
                         height="120"
                         id="profilePhoto" style="cursor: pointer;">
                </div>

            <!-- Chat Button -->
            <div class="mt-3">
                <a href="{{ route('chat.user', $user->id) }}" class="btn btn-primary px-4 py-2" style="background-color: #364360; border-color: #364360;">
                    Send Message
                </a>
            </div>
        </div>
    </div>

    <!-- User Information Section -->
    <div class="text-center mb-5">
        <h4 class="font-weight-bold">{{ $user->username }}</h4>
        <p class="lead mb-2"><strong>Full Name:</strong> {{ $user->fullname }}</p>
        <p class="lead mb-2"><strong>Email:</strong> {{ $user->email }}</p>
    </div>

    <!-- Single Product Section -->
    <div class="mb-5">
        <h4 class="text-dark font-weight-bold mb-3">{{ $user->username }}'s Product</h4>
        @if($products->isEmpty())
            <div class="alert alert-warning text-center">This user hasn't uploaded any products yet.</div>
        @else
            <div class="card mb-3 shadow-lg border-0 rounded-lg">
                <div class="card-body">
                    <!-- Display product photo if available -->
                    @if($products[0]->gambar_barang)
                        <img src="{{ Storage::url($products[0]->gambar_barang) }}" 
                             alt="{{ $products[0]->nama_barang }}" 
                             class="img-fluid mb-3 rounded-lg" 
                             style="height: 200px; object-fit: cover;">
                    @endif

                    <h5 class="font-weight-bold">{{ $products[0]->nama_barang }}</h5>
                    <p><strong>Price:</strong> Rp{{ number_format($products[0]->harga_barang, 0, ',', '.') }}</p>
                    <p><strong>Tag:</strong> {{ $products[0]->tag_barang }}</p>
                    <p><strong>Description:</strong> {{ $products[0]->deskripsi_barang }}</p>
                    <p><strong>Stock:</strong> {{ $products[0]->jumlah_barang }}</p>

                    <!-- Buttons for product actions -->
                    <div class="d-flex justify-content-start mt-3">
                        <a href="{{ route('product.show', $products[0]->id) }}" class="btn btn-primary btn-sm" style="background-color: #364360; border-color: #364360;">View Details</a>
                        <a href="{{ route('user.productsOther', ['id' => $user->id]) }}" class="btn btn-outline-secondary btn-sm ms-3">Show All Products</a>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Single Post Section -->
    <div class="mb-5">
        <h4 class="text-dark font-weight-bold mb-3">{{ $user->username }}'s Post</h4>
        @if($posts->isEmpty())
            <div class="alert alert-warning text-center">This user hasn't created any posts yet.</div>
        @else
            <div class="card mb-3 shadow-lg border-0 rounded-lg">
                <div class="card-body">
                    
                    <div class="card-body">
                    <!-- Display product photo if available -->
                    @if($posts[0]->image_url)
                        <img src="{{ Storage::url($posts[0]->image_url) }}" 
                             alt="{{ $posts[0]->image_url }}" 
                             class="img-fluid mb-3 rounded-lg" 
                             style="height: 200px; object-fit: cover;">
                    @endif
                    <p class="font-italic">{{ $posts[0]->content }}</p>
                    
                    <!-- Buttons for post actions -->
                    <div class="d-flex justify-content-start mt-3">
                        <a href="{{ route('post.show', $posts[0]->id) }}" class="btn btn-primary btn-sm" style="background-color: #364360; border-color: #364360;">View Post</a>
                        <a href="{{ route('user.allPostOther', ['id' => $user->id]) }}" class="btn btn-outline-secondary btn-sm ms-3">Show All Posts</a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
