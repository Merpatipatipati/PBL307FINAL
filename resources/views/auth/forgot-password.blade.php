<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="login-container">
        <div class="login-wrap">
            <h1 class="login-heading">Forgot Password</h1>
            
            @if(session('success'))
                <p class="success-message">{{ session('success') }}</p>
            @elseif(session('error'))
                <p class="error-message">{{ session('error') }}</p>
            @endif

            <form action="{{ route('password.email') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                <button type="submit" class="btn-login">Send Password Reset Link</button>
            </form>
        </div>
    </div>
</body>
</html>

