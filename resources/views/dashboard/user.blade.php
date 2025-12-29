<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .notification-wrapper {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            cursor: pointer;
        }
        .bell-icon {
            font-size: 30px;
            text-decoration: none;
        }
        /* The Red Badge Counter */
        .badge-count {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: red;
            color: white;
            border-radius: 50%;
            padding: 4px 8px;
            font-size: 12px;
            font-weight: bold;
        }
    </style>
</head>
<body class="p-5">

    <a href="{{ route('notifications.index') }}" class="notification-wrapper text-decoration-none">
        <span class="bell-icon">🔔</span>
        
        @if(auth()->user()->unreadNotifications->count() > 0)
            <span class="badge-count">{{ auth()->user()->unreadNotifications->count() }}</span>
        @endif
    </a>

    <h1>User Dashboard</h1>
    <p>Welcome, {{ auth()->user()->name }}!</p>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="btn btn-danger">Logout</button>
    </form>

    <hr>

    <h2>What would you like to do?</h2>

    <div class="mb-3">
        <a href="{{ route('properties.index') }}" class="btn btn-primary">
           Show All Properties
        </a>
    </div>

    <div class="mb-3">
        <a href="{{ route('my-bookings') }}" class="btn btn-success">
           Show My Booked Properties
        </a>
    </div>

</body>
</html>