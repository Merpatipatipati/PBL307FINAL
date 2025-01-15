<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login</title>
  <link rel="stylesheet" href="/css/Admin/login.css">
</head>
<body>
  <div class="overlay-text">
    <h1 class="welcome-title">Welcome to Admin</h1>
    <h2 class="subtitle">Sign in to your account</h2>
  </div>
  
  <div class="login-container">
    <div class="login-box">
    <form action="{{ route('admin.login') }}" method="POST">
    @csrf
    <div class="input-group">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" required>
    </div>
    <div class="input-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
    </div>
    <button type="submit">Login</button>
</form>

    </div>
    </div>
  </div>
</body>
@if (session('error'))
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: "{{ session('error') }}",
    });
</script>
@endif
</html>

