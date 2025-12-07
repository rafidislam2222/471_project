<!DOCTYPE html>
<html>
<head>
    <title>Create Account</title>
</head>
<body>

<h2>Register</h2>

@if(session('success'))
<p style="color: green;">{{ session('success') }}</p>
@endif

<form action="/register" method="POST">
    @csrf

    <input type="text" name="name" placeholder="Name" required><br><br>

    <input type="email" name="email" placeholder="Email" required><br><br>

    <input type="password" name="password" placeholder="Password" required><br><br>

    <select name="role" required>
        <option value="user">User</option>
        <option value="owner">Owner</option>
        <option value="admin">Admin</option>
    </select><br><br>

    <button type="submit">Create Account</button>
</form>

<p>Already have an account? <a href="/login">Login</a></p>

</body>
</html>
