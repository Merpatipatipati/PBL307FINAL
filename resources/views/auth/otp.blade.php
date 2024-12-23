<!-- resources/views/emails/otp.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
</head>
<body>
    <h1>OTP Verification</h1>
    <p>Hi {{ $user->fullname }},</p>
    <p>Your OTP code is: <strong>{{ $otp }}</strong></p>
    <p>Please enter this code in the application to verify your account.</p>
    <p>Thank you for using our service!</p>
</body>
</html>

