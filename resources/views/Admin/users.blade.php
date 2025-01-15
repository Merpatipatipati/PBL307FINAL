<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Sidebar</title>
  <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
  <link rel="stylesheet" href="/css/Admin/users.css">
  <link rel="stylesheet" href="/css/Admin/sidebar-design.css">
  
  <!-- DataTables CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script defer src="{{ asset('js/users.js') }}"></script>
  <script defer src="{{ asset('js/sidebar-function.js') }}"></script>

  <!-- jQuery (required for DataTables) -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- DataTables JS -->
  <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
</head>

<body>
  <div class="dashboard">
    <!-- Sidebar -->
    <nav class="sidebar close">
      <header>
        <div class="image-text">
          <div class="text logo-text">
            <span class="name">User Management</span>
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
            <a href="{{ route('admin.users') }}" class="active">
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

    <!-- Main Content -->
    <section class="home">   
      <div class="main-content">
        <div class="header">
          <h1>Users Management</h1>
        </div>

        <div class="content-section">
          <h2>All Registered Users</h2>
          <!-- Add the DataTable class to the table -->
          <table id="usersTable" class="display">
            <thead>
              <tr>
                <th>Photo profile</th>
                <th>Name</th>
                <th>Email</th>
                <th>Status</th>
                <th>Role</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($users as $user)
              <tr data-id="{{ $user->id }}">
                <td>
                  @if($user->photo)
                    <img src="{{ Storage::url($user->photo) }}" alt="{{ $user->photo }}" style="width: 100px;">
                  @else
                    <span>No Image</span>
                  @endif
                </td>
                <td class="username">{{ $user->username }}</td>
                <td class="email">{{ $user->email }}</td>
                <td class="status">{{ $user->status }}</td>
                <td class="role">{{ $user->role }}</td>
                <td>
                  <button class="edit-btn" data-id="{{ $user->id }}">Edit</button>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>

      <!-- Modal for editing a user -->
      <div id="editModal" class="modal">
        <div class="modal-content">
          <span class="close2">&times;</span>
          <h2>Edit User</h2>
          <form id="editForm" action="{{ route('admin.users.update', ['id' => $user->id ?? '']) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" id="user-id" name="id" value="{{ $user->id ?? '' }}">

            <label for="username">Username</label>
            <input type="text" name="username" id="username" required>

            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>

            <label for="status">Status</label>
            <select name="status" id="status">
              <option value="Verified">Verified</option>
              <option value="Non-Verified">Non-Verified</option>
              <option value="Banned">Banned</option>
            </select>

            <label for="role">Role</label>
            <select name="role" id="role">
              <option value="user">User</option>
              <option value="admin">Admin</option>
            </select>

            <button type="submit">Update</button>
          </form>
        </div>
      </div>
    </section>
  </div>

  <script>
    // Initialize DataTable on the table with id 'usersTable'
    $(document).ready(function() {
      $('#usersTable').DataTable({
        "paging": true,        // Enable pagination
        "searching": true,     // Enable search
        "ordering": true,      // Enable column sorting
        "lengthChange": false, // Disable changing the number of rows per page
        "autoWidth": false,    // Disable automatic column width calculation
      });
    });
  </script>
</body>
</html>
