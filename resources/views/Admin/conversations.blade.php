<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Sidebar</title>
  <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="{{ asset('/css/Admin/conversation.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/Admin/sidebar-design.css') }}">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
  <script defer src="{{ asset('js/conversation.js') }}"></script>
  <script defer src="{{ asset('js/sidebar-function.js') }}"></script>
</head>
<body>
  <div class="dashboard">
    <!-- Sidebar -->
    <nav class="sidebar close">
      <header>
        <div class="image-text">
          <div class="text logo-text">
            <span class="name">Post Management</span>
            <span class="profession">Openshop</span>
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
            <a href="{{ route('admin.posts') }}" class="active">
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

    <section class="home">
      <!-- Main Content -->
      <div class="main-content">
        <div class="header">
          <h1>Post Management</h1>
        </div>
        <div class="content-section">
          <h2>All Posts</h2>
          <table id="posts-table">
            <thead>
              <tr>
                <th>Content</th>
                <th>Created By</th>
                <th>Image</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($posts as $post)
                <tr>
                  <td>{{ \Str::limit($post->content, 50) }}</td>
                  <td>{{ $post->user->username ?? 'Unknown User' }}</td>
                  <td class="post-image">
                    @if($post->image_url)
                      <img src="{{ Storage::url($post->image_url) }}" alt="{{ $post->image_url }}" style="width: 100px;">
                    @else
                      <span>No Image</span>
                    @endif
                  </td>
                  <td>
                    @if($post->status == 'takedown')
                      <form action="{{ route('admin.post.untakedown', $post->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="untakedown-btn">Untakedown</button>
                      </form>
                    @else
                      <form action="{{ route('admin.post.takedown', $post->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="takedown-btn">Takedown</button>
                      </form>
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </section>
  </div>

  <script>
    $(document).ready(function() {
      $('#posts-table').DataTable({
        "paging": true,
        "searching": true,  // Enables the search functionality
        "info": false,      // Disables the information display at the bottom
        "autoWidth": false, // Disables auto width calculation for columns
        "lengthChange": false // Disable change number of entries per page
      });
    });
  </script>
</body>
</html>
