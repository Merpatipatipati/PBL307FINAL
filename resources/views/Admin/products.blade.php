<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Sidebar</title>
  <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
  <link rel="stylesheet" href="/css/Admin/products.css">
  <link rel="stylesheet" href="/css/Admin/sidebar-design.css">

  <!-- DataTables CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">

  <script defer src="{{ asset('js/products.js') }}"></script>
  <script defer src="{{ asset('js/sidebar-function.js') }}"></script>

  <!-- DataTables JS -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

  <script>
    $(document).ready(function() {
      // Initialize DataTable
      $('table').DataTable({
        responsive: true,
        searching: true, // Enable search bar
        ordering: true,  // Allow sorting
        pageLength: 10,  // Limit number of rows per page
      });
    });
  </script>
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
            <a href="{{ route('admin.products') }}" class="active">
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
        <h1>Product Management</h1>
        <table id="productsTable">
          <thead>
            <tr>
              <th>Product Name</th>
              <th>Tag</th>
              <th>Price</th>
              <th>Quantity</th>
              <th>Description</th>
              <th>Image</th>
              <th>Uploaded By</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($products as $product)
              <tr>
                <td>{{ $product->nama_barang }}</td>
                <td>{{ $product->tag_barang }}</td>
                <td>Rp{{ number_format($product->harga_barang, 0, ',', '.') }}</td>
                <td>{{ $product->jumlah_barang }}</td>
                <td>{{ $product->deskripsi_barang }}</td>
                <td>
                  @if($product->gambar_barang)
                    <img src="{{ Storage::url($product->gambar_barang) }}" alt="{{ $product->nama_barang }}" style="width: 100px;">
                  @else
                    <span>No Image</span>
                  @endif
                </td>
                <td>{{ $product->user->username ?? 'Unknown User' }}</td>
                <td>
                  @if($product->takedown)
                    <button class="untakedown-btn" onclick="event.preventDefault(); document.getElementById('untakedown-form-{{ $product->id }}').submit();">Restore</button>
                    <form id="untakedown-form-{{ $product->id }}" action="{{ route('admin.products.untakedown', $product->id) }}" method="POST" style="display: none;">
                      @csrf
                    </form>
                  @else
                    <button class="takedown-btn" onclick="event.preventDefault(); document.getElementById('takedown-form-{{ $product->id }}').submit();">Takedown</button>
                    <form id="takedown-form-{{ $product->id }}" action="{{ route('admin.products.takedown', $product->id) }}" method="POST" style="display: none;">
                      @csrf
                    </form>
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </section>
  </div>
</body>
</html>
