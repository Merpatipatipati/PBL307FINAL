<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="{{ asset('css/app.blade.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm mb-4">
    <div class="container">
        <!-- Navbar Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <!-- MarketPlace -->
                <li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                    <a class="nav-link custom-nav-link" href="{{ route('home') }}">
                        <i class="fas fa-store-alt"></i> MarketPlace
                    </a>
                </li>
                <!-- Explore -->
                <li class="nav-item {{ request()->routeIs('user.managePost') ? 'active' : '' }}">
                    <a class="nav-link custom-nav-link" href="{{ route('user.managePosts') }}">
                        <i class="fas fa-compass"></i> Explore
                    </a>
                </li>
                <!-- Upload -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle custom-nav-link {{ request()->routeIs('user.createPost') || request()->routeIs('products.create') ? 'active' : '' }}" 
                       href="#" id="uploadDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-upload"></i> Upload
                    </a>
                    <div class="dropdown-menu" aria-labelledby="uploadDropdown">
                        <a class="dropdown-item {{ request()->routeIs('user.createPost') ? 'active' : '' }}" href="{{ route('user.createPost') }}">
                            <i class="fas fa-file-alt"></i> Upload Post
                        </a>
                        <a class="dropdown-item {{ request()->routeIs('products.create') ? 'active' : '' }}" href="{{ route('products.create') }}">
                            <i class="fas fa-box-open"></i> Upload Item
                        </a>
                    </div>
                </li>
                <!-- Profile -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle custom-nav-link" href="#" id="profileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user"></i> Profile
                    </a>
                    <div class="dropdown-menu" aria-labelledby="profileDropdown">
                        <a class="dropdown-item {{ request()->routeIs('user.dashboard') ? 'active' : '' }}" href="{{ route('user.dashboard') }}">
                            <i class="fas fa-user-circle"></i> My Profile
                        </a>
                        <a class="dropdown-item {{ request()->routeIs('message.index') ? 'active' : '' }}" href="{{ route('message.index') }}">
                            <i class="fas fa-envelope"></i> Chat
                        </a>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>

            <!-- Search Form -->
            <form class="form-inline my-2 my-lg-0" action="{{ route('products.search') }}" method="GET">
                <div class="input-group">
                    <input class="form-control" type="search" name="query" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-primary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</nav>

<!-- Main Content -->
<main>
    <div class="container mt-4">
        @yield('content')
    </div>
</main>

<!-- Footer -->
<footer class="bg-dark text-white py-4 mt-5">
    <div class="container text-center">
        <p>&copy; {{ date('Y') }} My Marketplace. All rights reserved.</p>
    </div>
</footer>

<!-- JavaScript -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
