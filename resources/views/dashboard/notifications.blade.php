<!DOCTYPE html>
<html>
<head><title>Notifications</title></head>
<body>
    <h1>My Notifications</h1>
    <ul>
        @foreach($notifications as $notification)
            <li>
                {{ $notification->data['message'] ?? 'New Notification' }}
                <br>
                <small>{{ $notification->created_at->diffForHumans() }}</small>
            </li>
        @endforeach
    </ul>
    <a href="/dashboard">Back to Dashboard</a>
</body>
</html>