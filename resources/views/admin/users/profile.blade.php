<!DOCTYPE html>
<html>
<head>
    <title>User Profile</title>
</head>
<body>

<h1>User Profile</h1>

<p><strong>ID:</strong> {{ $user->id }}</p>
<p><strong>Name:</strong> {{ $user->name }}</p>
<p><strong>Email:</strong> {{ $user->email }}</p>
<p><strong>Role:</strong> {{ $user->role }}</p>
<p><strong>Status:</strong> {{ $user->status }}</p>
<p><strong>Suspended Until:</strong> {{ $user->suspended_until ?? 'Not suspended' }}</p>

<br>
<a href="{{ route('admin.users.index') }}">← Back to Manage Users</a>

</body>
</html>
