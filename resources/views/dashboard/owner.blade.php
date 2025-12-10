<!DOCTYPE html>
<html>
<head>
    <title>Owner Dashboard</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body { font-family: sans-serif; margin: 30px; }

        /* Layout for Title + Bell */
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #eee;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        /* --- Notification Styles --- */
        .notification-wrapper {
            position: relative;
            cursor: pointer;
            margin-right: 15px;
        }
        .bell-icon {
            font-size: 26px;
            color: #555;
            transition: color 0.3s;
        }
        .bell-icon:hover { color: #000; }

        /* The Red Badge */
        .badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: red;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 11px;
            font-weight: bold;
        }

        /* The Dropdown Box */
        .notif-dropdown {
            display: none; /* Hidden by default */
            position: absolute;
            right: 0;
            top: 40px;
            width: 320px;
            background-color: white;
            border: 1px solid #ccc;
            box-shadow: 0px 4px 10px rgba(0,0,0,0.15);
            z-index: 1000;
            border-radius: 6px;
        }
        .notif-header {
            background-color: #f8f9fa;
            padding: 10px;
            border-bottom: 1px solid #eee;
            font-weight: bold;
            color: #333;
        }
        .notif-item {
            padding: 12px;
            border-bottom: 1px solid #f1f1f1;
            font-size: 13px;
            display: block;
            text-decoration: none;
            color: #333;
        }
        .notif-item:hover { background-color: #f0f2f5; }
    </style>
</head>
<body>

<div class="header-container">
    <div>
        <h1>Owner Dashboard</h1>
        <p style="margin:0; color:gray;">Welcome Owner!</p>
    </div>

    <div class="notification-wrapper" onclick="toggleDropdown()">
        <i class="fas fa-bell bell-icon"></i>
        
        @if(auth()->user()->unreadNotifications->count() > 0)
            <span class="badge" id="notifBadge">{{ auth()->user()->unreadNotifications->count() }}</span>
        @endif

        <div class="notif-dropdown" id="notificationBox">
            <div class="notif-header">
                Notifications
            </div>

            <div style="max-height: 300px; overflow-y: auto;">
                @forelse(auth()->user()->unreadNotifications as $notification)
                    <a href="{{ $notification->data['url'] ?? '#' }}" class="notif-item">
                        <strong>{{ $notification->data['message'] }}</strong> <br>
                        <small style="color:gray;">{{ $notification->created_at->diffForHumans() }}</small>
                    </a>
                @empty
                    <div style="padding:20px; text-align:center; color:gray;">No new notifications</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div style="margin-top: 30px;">
    <a href="/owner/properties/create"
       style="padding:10px 15px; background:#28a745; color:white; text-decoration:none; border-radius:5px; margin-right:10px;">
       ➕ Add New Property
    </a>

    <a href="/owner/properties"
       style="padding:10px 15px; background:#007bff; color:white; text-decoration:none; border-radius:5px; margin-right:10px;">
       📄 Show My Properties
    </a>

    <a href="/logout"
       style="padding:10px 15px; background:#dc3545; color:white; text-decoration:none; border-radius:5px;">
       🚪 Logout
    </a>
</div>

<script>
    function toggleDropdown() {
        var box = document.getElementById("notificationBox");
        var badge = document.getElementById("notifBadge");

        if (box.style.display === "none" || box.style.display === "") {
            box.style.display = "block";

            // Hide badge immediately
            if (badge) {
                badge.style.display = 'none';
            }

            // Call Laravel to mark as read
            fetch("{{ route('markAsRead') }}");

        } else {
            box.style.display = "none";
        }
    }

    // Close if clicking outside
    window.onclick = function(event) {
        if (!event.target.closest('.notification-wrapper')) {
            document.getElementById("notificationBox").style.display = "none";
        }
    }
</script>

</body>
</html>