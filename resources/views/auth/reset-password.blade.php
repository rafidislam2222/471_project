<!DOCTYPE html>
<html>
<head>
    <title>Set New Password</title>
</head>
<body>

<h2>Create New Password</h2>

@if(session('error'))
    <p style="color: red;">{{ session('error') }}</p>
@endif

<form action="/reset-password-verify" method="POST">
    @csrf
    
    <input type="email" name="email" placeholder="Confirm your email" required><br><br>

    <input type="text" name="otp" placeholder="Enter OTP from email" required><br><br>

    <input type="password" name="password" placeholder="New Password" required><br><br>
    
    <input type="password" name="password_confirmation" placeholder="Confirm New Password" required><br><br>

    <button type="submit">Change Password</button>
</form>

</body>
</html>