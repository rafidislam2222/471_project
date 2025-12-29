<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
 

<div class="screen">
    <div class="topbar">
        <div class="topbar-title">User Management</div>
        <div class="topbar-right">Admin User</div>
    </div>

    <div class="page-inner">
        <div class="card">
            <h1 style="margin-bottom: 10px;">Admin Dashboard</h1>
            <p class="lead" style="margin-bottom: 16px;">
                From here, the admin can manage all users in the system.
            </p>

            <a href="{{ route('admin.users.index') }}" class="btn btn-primary">
                Go to User Management
            </a>
        </div>
    </div>
</div>

</body>
</html>
