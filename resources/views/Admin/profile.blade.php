<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Sidebar</title>
  <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
  <link rel="stylesheet" href="/css/Admin/profile.css">
  <link rel="stylesheet" href="/css/Admin/sidebar-design.css">
<script defer src="{{ asset('js/sidebar-function.js') }}"></script>
</head>
<body>
  <div class="dashboard">
    <!-- Sidebar -->
    <nav class="sidebar close">
      <header>
        <div class="image-text">
          <div class="text logo-text">
            <span class="name">{{ Auth::user()->name }}</span>
            <span class="profession">Admin</span>
          </div>
        </div>
        <i class='bx bx-chevron-right toggle'></i>
      </header>

      <div class="menu-bar">
        <ul class="menu-links">
          <li class="nav-link">
            <a href="{{ route('admin.dashboard') }}">
              <i class='bx bx-home-alt icon'></i>
              <span class="text nav-text">Dashboard</span>
            </a>
          </li>
          <li class="nav-link">
            <a href="{{ route('admin.users') }}">
              <i class='bx bx-user-circle icon'></i>
              <span class="text nav-text">Users</span>
            </a>
          </li>
          <li class="nav-link">
            <a href="{{ route('admin.products') }}">
              <i class='bx bx-box icon'></i>
              <span class="text nav-text">Products</span>
            </a>
          </li>
          <li class="nav-link">
            <a href="{{ route('admin.posts') }}">
              <i class='bx bx-conversation icon'></i>
              <span class="text nav-text">Conversations</span>
            </a>
          </li>
          <li class="nav-link">
            <a href="{{ route('admin.reports') }}">
              <i class='bx bx-help-circle icon'></i>
              <span class="text nav-text">Reports</span>
            </a>
          </li>
          <li class="nav-link">
            <a href="{{ route('admin.profile') }}" class="active">
              <i class='bx bx-user icon'></i>
              <span class="text nav-text">Profile</span>
            </a>
          </li>
        </ul>
        <div class="bottom-content">
          <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class='bx bx-log-out icon'></i>
            <span class="text nav-text">Logout</span>
          </a>
          <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
            @csrf
          </form>
        </div>
      </div>
    </nav>

    <section class="home">
      <!-- Main Content -->
      <div class="main-content">
        <div class="header">
          <h1>Admin Profile</h1>
        </div>

        <div class="profile-section">
          <div class="profile-info">
            <h2>Profile Information</h2>
            <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="Profile Picture" class="profile-pic">

            <div class="profile-data-grid">
              <div class="profile-data-item">
                <strong>Name:</strong> <span>{{ $admin->fullname }}</span>
              </div>
              <div class="profile-data-item">
                <strong>Email:</strong> <span>{{ $admin->email }}</span>
              </div>
              <div class="profile-data-item">
                <strong>Username:</strong> <span>{{ $admin->username }}</span>
              </div>
              <div class="profile-data-item">
                <strong>Role:</strong> <span>{{ $admin->role }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</body>
</html>
