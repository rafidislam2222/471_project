<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>
<body>

<h1>Admin Dashboard</h1>
<p>Welcome Admin!</p>

<ul>
    <li><a href="{{ route('admin.users.index') }}">Manage Users</a></li>
    {{-- Later you can add more admin links here --}}
</ul>

<p><a href="/logout">Logout</a></p>

</body>
</html>
