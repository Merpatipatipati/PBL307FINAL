<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="{{ asset('css/styless.css') }}">
    <!-- SweetAlert CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="reset-container">
        <div class="reset-wrap">
            <h1 class="reset-heading">Reset Password</h1>

            @if(session('error'))
                <p class="error-message">{{ session('error') }}</p>
            @endif

            <form action="{{ route('password.update') }}" method="POST" id="resetPasswordForm">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group">
                    <label for="password">Password Baru:</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password Baru:</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                </div>

                <button type="submit" class="btn-reset">Reset Password</button>
            </form>
        </div>
    </div>

    <script>
        // Validasi saat form disubmit
        document.getElementById('resetPasswordForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const password = document.getElementById('password').value;
            const passwordConfirmation = document.getElementById('password_confirmation').value;

            // Cek kriteria password
            if (password.length < 8) {
                Swal.fire({
                    icon: 'error',
                    title: 'Password terlalu pendek',
                    text: 'Password harus terdiri dari minimal 8 karakter.',
                });
                return;
            }

            // Cek apakah password dan konfirmasi password cocok
            if (password !== passwordConfirmation) {
                Swal.fire({
                    icon: 'error',
                    title: 'Password tidak cocok',
                    text: 'Password baru dan konfirmasi password harus sama.',
                });
                return;
            }

            // Jika validasi berhasil, kirim form
            this.submit();
        });
    </script>
</body>
</html>

