<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
    <style>
        .notification-bell {
            position: fixed;
            top: 20px;
            right: 20px;
            font-size: 28px;
            cursor: pointer;
            z-index: 1000;
            transition: transform 0.2s ease;
        }
        .notification-bell:hover {
            transform: scale(1.1);
        }
    </style>
</head>
<body>

<div class="notification-bell" title="Notifications">
    🔔
</div>

<h1>User Dashboard</h1>
<p>Welcome, {{ auth()->user()->name }}!</p>

<a href="/logout">Logout</a>

<hr>

<h2>What would you like to do?</h2>

<!-- Show All Properties -->
<p>
    <a href="/properties" 
       style="padding:10px 20px; background:blue; color:white; text-decoration:none;">
       Show All Properties
    </a>
</p>

<!-- Show My Booked Properties -->
<p>
    <a href="/my-bookings"
       style="padding:10px 20px; background:green; color:white; text-decoration:none;">
       Show My Booked Properties
    </a>
</p>

</body>
</html>
