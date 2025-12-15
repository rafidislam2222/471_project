<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>

<h2>Login</h2>

@if(session('error'))
    <p style="color: red;">{{ session('error') }}</p>
@endif

<form action="/login" method="POST">
    @csrf

    <input type="email" name="email" placeholder="Email" required><br><br>

    <input type="password" name="password" placeholder="Password" required><br><br>
    <div style="margin-bottom: 15px;">
        <a href="/forgot-password" style="font-size: 14px; color: #007bff;">Forgot Password?</a>
    </div>

    <button type="submit">Login</button>
</form>

<p>Don't have an account? <a href="/register">Register</a></p>

</body>
</html>
