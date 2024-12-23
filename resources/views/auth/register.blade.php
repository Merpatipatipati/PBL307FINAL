<!doctype html>
<html lang="en">
<head>
    <title>Registration Page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- External CSS and Font -->
    <link rel="stylesheet" href="{{ asset('css/login_regis/register.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container">
    <div class="left-side">
            <div class="get-started">
                <h2>Get Started</h2>
                <p>Join us now and start your journey.</p>
            </div>
        </div>
        <div class="right-side">
            <div class="form-wrap p-4 p-md-5">
                <div class="icon d-flex align-items-center justify-content-center">
                    <i class="fa-solid fa-user"></i>
                </div>
                <h2 class="heading-section">Create an Account</h2>

                <!-- Registration Form -->
                <form action="{{ route('register') }}" method="POST" id="registration-form">
                    @csrf
                    <div class="form-group">
                        <input type="text" id="fullname" name="fullname" class="form-control rounded-left" placeholder="Full Name" value="{{ old('fullname') }}" required>
                    </div>

                    <div class="form-group">
                        <input type="text" id="username" name="username" class="form-control rounded-left" placeholder="Username" value="{{ old('username') }}" required>
                    </div>

                    <div class="form-group">
                        <input type="email" id="email" name="email" class="form-control rounded-left" placeholder="Email" value="{{ old('email') }}" required>
                    </div>

                    <div class="form-group">
                        <input type="password" id="password" name="password" class="form-control rounded-left" placeholder="Password" required>
                    </div>

                    <div class="form-group">
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control rounded-left" placeholder="Confirm Password" required>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary rounded submit p-3 px-5">Sign Up</button>
                    </div>
                </form>

                <!-- Already have an account -->
                <div class="text-center mt-4">
                    <p>Already have an account? <a href="{{ route('login') }}">Login here</a></p>
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert Error Handling -->
    @if ($errors->any())
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Registration Failed',
                    html: `<ul style="text-align: left;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>`,
                    confirmButtonColor: '#364360',
                }).then(() => {
                    document.getElementById('password').value = '';
                    document.getElementById('password_confirmation').value = '';
                });
            });
        </script>
    @endif

    <!-- SweetAlert for Registration Success or Already Registered -->
    @if (session('status') == 'user_registered')
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Registration Successful',
                    text: 'You have successfully registered. Please login now.',
                    confirmButtonColor: '#364360',
                }).then(() => {
                    window.location.href = "{{ route('login') }}";
                });
            });
        </script>
    @endif
</body>
</html>
