<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Sidebar</title>
  <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
  <link rel="stylesheet" href="/css/Admin/reports.css">
  <link rel="stylesheet" href="/css/Admin/sidebar-design.css">
  
  <!-- DataTables CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
  
  <script defer src="{{ asset('js/sidebar-function.js') }}"></script>
  <script defer src="{{ asset('js/reports.js') }}"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
  </head>

<body>
  <div class="dashboard">
    <!-- Sidebar -->
    <nav class="sidebar close">
      <header>
        <div class="image-text">
          <span class="image">
            <img src="img/open.png" alt="Logo">
          </span>
          <div class="text logo-text">
            <span class="name">Stella Army</span>
            <span class="profession">Web Developer</span>
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
            <a href="{{ route('admin.products') }}" >
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
            <a href="{{ route('admin.reports') }}"class="active">
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
          <h1>Reports Management</h1>
        </div>

        <div class="content-section">
          <h2>Product Reports</h2>
          <table id="productReportsTable" class="display">
            <thead>
              <tr>
                <th>Reporter</th>
                <th>Product Name</th>
                <th>Seller</th>
                <th>Reason</th>
                <th>Admin Response</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
    @foreach($productReports as $report)
        <tr data-id="{{ $report->id }}">
            <td>{{ optional($report->reporter)->username ?? 'N/A' }}</td>
            <td>{{ optional($report->product)->nama_barang ?? 'N/A' }}</td>
            <td>{{ $report->product->user->username ?? 'N/A' }}</td>
            <td>{{ $report->reason ?? 'N/A' }}</td>
            <td class="status">{{ $report->status ?? 'Pending' }}</td> <!-- Displaying the status -->
            <td>
                <form class="report-form" data-type="product" data-id="{{ $report->id }}" method="POST" action="{{ route('reports.submit', ['reportId' => $report->id, 'reportType' => 'product']) }}">
                    @csrf
                    <button type="submit" class="submit-btn">Submit</button>
                </form>
            </td>
        </tr>
    @endforeach
</tbody>
          </table>

          <h3>Post Reports</h3>
          <table id="postReportsTable" class="display">
            <thead>
              <tr>
                <th>Reporter</th>
                <th>Post Content</th>
                <th>Author</th>
                <th>Reason</th>
                <th>Admin Response</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
    @foreach($postReports as $report)
        <tr data-id="{{ $report->id }}">
            <td>{{ optional($report->reporter)->username ?? 'N/A' }}</td>
            <td>{{ Str::limit(optional($report->post)->content, 50) ?? 'N/A' }}</td>
            <td>{{ $report->post->user->username ?? 'N/A' }}</td>
            <td>{{ $report->reason ?? 'N/A' }}</td>
            <td class="status">{{ $report->status ?? 'Pending' }}</td> <!-- Displaying the status -->
            <td>
                <form class="report-form" data-type="post" data-id="{{ $report->id }}" method="POST" action="{{ route('reports.submit', ['reportId' => $report->id, 'reportType' => 'post']) }}">
                    @csrf
                    <button type="submit" class="submit-btn">Submit</button>
                </form>
            </td>
        </tr>
    @endforeach
</tbody>
          </table>
        </div>
      </div>
    </section>
  </div>
</body>
</html>
