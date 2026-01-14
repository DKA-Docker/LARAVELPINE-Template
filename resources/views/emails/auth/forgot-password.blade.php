<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
    <h1>Reset Password Request</h1>
    <p>Hello,</p>
    <p>You are receiving this email because we received a password reset request for your account.</p>
    <p>
        <a href="{{ route('auth.reset-password', ['token' => $token, 'email' => $email]) }}">Reset Password</a>
    </p>
    <p>If you did not request a password reset, no further action is required.</p>
</body>
</html>
