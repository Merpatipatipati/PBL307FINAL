<html>
<head>
    <title>Reset Password</title>
</head>
<body>
    <h1>Reset Password</h1>
    <p>We received a request to reset your password. Click the link below to continue</p>
    <a href="{{ url('/reset-password/' . $token) }}">Reset Password</a>
    <p>If you did not request a password reset, ignore this email.</p>
</body>
</html>

