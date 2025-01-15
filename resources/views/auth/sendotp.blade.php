<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter OTP</title>
    <link rel="stylesheet" href="{{ asset('css/otp.css') }}">
</head>
<body>
    <div class="login-container">
        <div class="login-wrap">
            <h2 class="login-heading">Verify Your Account</h2>

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('otp.validate', ['id' => $id]) }}" method="POST" class="form-group">
                @csrf
                <label for="otp">Enter OTP</label>
                <input 
                    type="text" 
                    id="otp" 
                    name="otp" 
                    class="form-control" 
                    required 
                    maxlength="6" 
                    pattern="[0-9]{6}" 
                    title="OTP must be a 6-digit number." 
                    placeholder="123456" />
                @error('otp')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                <button type="submit" class="btn-login">Verify OTP</button>
            </form>

            <form action="{{ route('otp.send', ['id' => $id]) }}" method="POST">
                @csrf
                <button type="submit" class="btn-link">Resend OTP</button>
            </form>
        </div>
    </div>
</body>
</html>

