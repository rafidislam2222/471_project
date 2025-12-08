<!DOCTYPE html>
<html>
<head>
    <title>Admin – Manage Users</title>
</head>
<body>
<h1>Manage Users</h1>

@if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif

<table border="1" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Status</th>
        <th>Suspended Until</th>
        <th>Change Role</th>
        <th>Suspend</th>
        <th>Delete</th>
    </tr>

    @foreach($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->role }}</td>
            <td>{{ $user->status }}</td>
            <td>{{ $user->suspended_until }}</td>

            {{-- Change role --}}
            <td>
                <form action="{{ route('admin.users.updateRole', $user) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <select name="role">
                        <option value="user"  {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                        <option value="owner" {{ $user->role == 'owner' ? 'selected' : '' }}>Owner</option>
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    <button type="submit">Save</button>
                </form>
            </td>

            {{-- Suspend / unsuspend --}}
            <td>
                <form action="{{ route('admin.users.suspend', $user) }}" method="POST">
                    @csrf
                    <select name="type">
                        <option value="none">Remove suspension</option>
                        <option value="temporary">Temporary</option>
                        <option value="permanent">Permanent</option>
                    </select>
                    <input type="number" name="days" placeholder="Days (for temporary)" min="1" style="width: 130px;">
                    <button type="submit">Apply</button>
                </form>
            </td>
            //view profile
            <td>
                <a href="{{ route('admin.users.profile', $user) }}">
                    <button>View Profile</button>
                </a>
            </td>


            {{-- Delete --}}
            <td>
                <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                      onsubmit="return confirm('Delete this user permanently?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="color:red;">Delete</button>
                </form>
            </td>
        </tr>
    @endforeach
</table>

<p><a href="/admin/dashboard">Back to Dashboard</a></p>

</body>
</html>
