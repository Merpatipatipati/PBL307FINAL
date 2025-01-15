<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Boxicons -->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css">
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('/css/Admin/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/Admin/sidebar-design.css') }}">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  </head>
  <body>
    <section class="home">
      <div class="text">Dashboard</div>
      <div class="stats-container">
        <!-- Total Users -->
        <div class="stat-box blue">
          <p>Total Users</p>
          <p class="stat-number">{{ array_sum($totalUsers) }}</p>
          <canvas id="userChart" width="400" height="400"></canvas>
          <a href="{{ route('admin.users') }}" class="view-details">Lihat Detail Users</a>
        </div>

        <!-- Total Products -->
        <div class="stat-box green">
          <p>Total Products</p>
          <p class="stat-number">{{ array_sum($totalProducts) }}</p>
          <canvas id="productChart" width="400" height="400"></canvas>
          <a href="{{ route('admin.products') }}" class="view-details">Lihat Detail Products</a>
        </div>

        <!-- Total Posts -->
        <div class="stat-box orange">
          <p>Total Posts</p>
          <p class="stat-number">{{ array_sum($totalPosts) }}</p>
          <canvas id="postChart" width="400" height="400"></canvas>
          <a href="{{ route('admin.posts') }}" class="view-details">Lihat Detail Posts</a>
        </div>
      </div>
    </section>

    <nav class="sidebar close">
      <header>
        <div class="image-text">
          <div class="text logo-text">
            <span class="name">OpenShop</span>
            <span class="profession">Admin Dashboard</span>
          </div>
        </div>
        <i class='bx bx-chevron-right toggle'></i>
      </header>

      <div class="menu-bar">
        <ul class="menu-links">
          <li class="nav-link">
            <a href="{{ route('admin.dashboard') }}" class="active">
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
              <i class='bx bx-news icon'></i>
              <span class="text nav-text">Posts</span>
            </a>
          </li>
          <li class="nav-link">
            <a href="{{ route('admin.reports') }}">
              <i class='bx bx-help-circle icon'></i>
              <span class="text nav-text">Reports</span>
            </a>
          </li>
          <li class="nav-link">
            <a href="{{ route('admin.profile') }}">
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

    <!-- Custom JS -->
    <script>
      const totalUsersData = @json(array_values($totalUsers)); // Get values as an array of numbers
    const totalProductsData = @json(array_values($totalProducts)); // Get values as an array of numbers
    const totalPostsData = @json(array_values($totalPosts)); // Get values as an array of numbers

      // Sidebar Toggle
      document.querySelector('.toggle').addEventListener('click', function() {
        document.querySelector('.sidebar').classList.toggle('close');
      });
    </script>
    <script src="{{ asset('js/dashboard.js') }}"></script>
    
  </body>
</html>
