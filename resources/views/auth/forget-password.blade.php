<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
</head>
<body>

<h2>Reset Password</h2>

@if(session('error'))
    <p style="color: red;">{{ session('error') }}</p>
@endif
@if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif

<form action="/forgot-password-send-otp" method="POST">
    @csrf
    <p>Enter your email address and we will send you an OTP code.</p>
    
    <input type="email" name="email" placeholder="Enter your email" required><br><br>

    <button type="submit">Send OTP</button>
</form>

<p><a href="/login">Back to Login</a></p>

</body>
</html>