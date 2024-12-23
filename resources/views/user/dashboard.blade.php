@extends('layouts.app')

<link href="{{ asset('css/home/user.css') }}" rel="stylesheet">

@section('content')
<div class="container mt-5">
    <!-- Dynamic Title -->
    <h2 class="text-center mb-4 text-dark font-weight-bold">Welcome to {{ Auth::user()->username }}'s Profile</h2>

    <!-- Profile Photo Section (Centered with Hover Effect) -->
    <div class="d-flex justify-content-center mb-5">
        <form action="{{ route('user.updatePhoto') }}" method="POST" enctype="multipart/form-data" id="photo-upload-form">
            @csrf
            @method('POST')
            <div class="text-center">
                <div class="profile-photo-container">
                    <img src="{{ Storage::url($user->photo) }}" alt="{{ $user->photo }}" 
                         alt="User Profile Photo" 
                         class="rounded-circle border shadow-lg" 
                         width="120" 
                         height="120"
                         id="profilePhoto" style="cursor: pointer;">
                </div>
                <!-- File input to change profile photo -->
                <input type="file" name="photo" class="form-control-file" id="photoUpload" style="display: none;" onchange="this.form.submit()">
                
                <!-- Label to trigger file input -->
                <label for="photoUpload" class="btn btn-secondary btn-sm mt-2 px-4">Change Photo</label>
            </div>
        </form>
    </div>

    <!-- User Information Section -->
    <div class="text-center mb-5">
        <h4 class="font-weight-bold">{{ Auth::user()->username }}</h4>
        <p class="lead mb-2"><strong>Full Name:</strong> {{ Auth::user()->fullname }}</p>
        <p class="lead mb-2"><strong>Email:</strong> {{ Auth::user()->email }}</p>  <!-- Added Email field -->
    </div>

    <!-- Display Success or Error Message from Session -->
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('success') }}',
                confirmButtonColor: '#364360',
            });
        </script>
    @elseif (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}',
                confirmButtonColor: '#364360',
            });
        </script>
    @endif

    <!-- List of User's Products -->
    <div class="mb-5">
        <h4 class="text-dark font-weight-bold mb-3">Your Products({{ $products->count() }})</h4>
        @if($products->isEmpty())
            <div class="alert alert-warning text-center">You haven't uploaded any products yet.</div>
        @else
            @php
                $latestProduct = $products->first();
            @endphp
            <div class="card mb-3 shadow-lg border-0 rounded-lg">
                <div class="card-body">
                    <!-- Display latest product photo if available -->
                    @if($latestProduct->gambar_barang)
                        <img src="{{ Storage::url($latestProduct->gambar_barang) }}" 
                             alt="{{ $latestProduct->nama_barang }}" 
                             class="img-fluid mb-3 rounded-lg" 
                             style="height: 200px; object-fit: cover;">
                    @endif

                    <h5 class="font-weight-bold">{{ $latestProduct->nama_barang }}</h5>
                    <p><strong>Price:</strong> Rp{{ number_format($latestProduct->harga_barang, 0, ',', '.') }}</p>
                    <p><strong>Tag:</strong> {{ $latestProduct->tag_barang }}</p>
                    <p><strong>Description:</strong> {{ $latestProduct->deskripsi_barang }}</p>
                    <p><strong>Stock:</strong> {{ $latestProduct->jumlah_barang }}</p>

                    <!-- Button to view details of the latest product -->
                    <div class="d-flex justify-content-start mt-3">
                        <a href="{{ route('product.show', $latestProduct->id) }}" class="btn btn-primary btn-sm" style="background-color: #364360; border-color: #364360;">View Details</a>
                        <a href="{{ route('user.products') }}" class="btn btn-outline-secondary btn-sm ms-3">View All Your Products</a>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="mb-5">
        <h4 class="text-dark font-weight-bold mb-3">Your Posts ({{ $posts->count() }})</h4>
        @if($posts->isEmpty())
            <div class="alert alert-warning text-center">You haven't created any posts yet.</div>
        @else
            @php
                $latestPost = $posts->first();
            @endphp
            <div class="card mb-3 shadow-lg border-0 rounded-lg">
                <div class="card-body">
                    <!-- Display latest post photo if available -->
                    @if($latestPost->image_url)
                        <img src="{{ Storage::url($latestPost->image_url) }}" 
                             alt="Post Image" 
                             class="img-fluid mb-3 rounded-lg" 
                             style="height: 200px; object-fit: cover;">
                    @endif

                    <p class="font-italic">{{ $latestPost->content }}</p>

                    <!-- Buttons to view details of the latest post -->
                    <div class="d-flex justify-content-start mt-3">
                        <a href="{{ route('post.show', $latestPost->id) }}" class="btn btn-primary btn-sm" style="background-color: #364360; border-color: #364360;">View Details</a>
                        <a href="{{ route('user.allPost', ['id' => $user->id]) }}" class="btn btn-outline-secondary btn-sm ms-3">View All Your Posts</a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- SweetAlert 2 Script (if not included) -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- JavaScript Validation for file size -->
<script>
    document.getElementById('photoUpload').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const maxSize = 5 * 1024 * 1024; // 5MB
        
        if (file && file.size > maxSize) {
            Swal.fire({
                icon: 'error',
                title: 'File Too Large',
                text: 'Please upload a file smaller than 5MB.',
                confirmButtonColor: '#364360',
            });
            e.target.value = ''; // Reset file input
        }
    });
</script>

@endsection
