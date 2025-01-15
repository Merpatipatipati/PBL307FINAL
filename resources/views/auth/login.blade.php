<!doctype html>
<html lang="en">
<head>
    <title>Login Page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Custom CSS for login form -->
    <link rel="stylesheet" href="{{ asset('css/login_regis/login.css') }}">

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="login-container">
        <div class="login-wrap">
            <div class="login-icon">
                <i class="fas fa-user"></i>
            </div>
            <h2 class="login-heading">Login</h2>

            <!-- Login Form -->
            <form action="{{ route('login') }}" method="POST" class="login-form">
                @csrf
                <div class="form-group">
                    <input type="text" name="login" id="login" class="form-control" placeholder="Username or Email" required value="{{ old('login') }}">
                </div>

                <div class="form-group">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                </div>

                <div class="form-footer">
                    <div class="forgot-password">
                        <a href="{{ route('password.request') }}">Forgot Password?</a>
                    </div>
                    <button type="submit" class="btn btn-login">Login</button>
                </div>
            </form>

            <div class="signup-link">
                <p>Not a member? <a href="{{ route('register') }}">Sign up Now</a></p>
            </div>
        </div>
    </div>

    <!-- SweetAlert for error or success messages -->
@if(session('error'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: "{{ session('error') }}",
                confirmButtonColor: '#364360',
            });
        });
    </script>
@elseif ($errors->any())
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: 'error',
                title: 'Login Failed',
                text: "{{ $errors->first() }}",
                confirmButtonColor: '#364360',
            });
        });
    </script>
@elseif(session('non_verified'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: 'warning',
                title: 'Account Not Verified',
                text: "{{ session('non_verified') }}",
                confirmButtonColor: '#364360',
            });
        });
    </script>
@elseif(session('banned'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: 'error',
                title: 'Account Banned',
                text: "{{ session('banned') }}",
                confirmButtonColor: '#364360',
            });
        });
    </script>
@endif
</body>
</html>

