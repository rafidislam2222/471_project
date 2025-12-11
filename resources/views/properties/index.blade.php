<!DOCTYPE html>
<html>
<head>
    <title>All Properties</title>
</head>
<body>
{{-- START OF NOTIFICATION BAR --}}
<div style="background: #f8f9fa; padding: 10px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #ddd; margin-bottom: 20px;">
    
    <div>
        <strong>User Dashboard</strong>
    </div>

    <div style="display: flex; gap: 15px; align-items: center;">
        
        {{-- 1. Check if User is Logged In --}}
        @auth
            <div style="position: relative; display: inline-block;">
                
                {{-- 2. The Bell Icon & Count --}}
                <button onclick="document.getElementById('notif-dropdown').classList.toggle('show')" style="background: none; border: none; cursor: pointer; font-size: 18px;">
                    🔔
                    @if(auth()->user()->unreadNotifications->count() > 0)
                        <span style="background: red; color: white; border-radius: 50%; padding: 2px 6px; font-size: 10px; position: absolute; top: -5px; right: -5px;">
                            {{ auth()->user()->unreadNotifications->count() }}
                        </span>
                    @endif
                </button>

                {{-- 3. The Dropdown Menu (Hidden by default) --}}
                <div id="notif-dropdown" style="display: none; position: absolute; right: 0; background: white; border: 1px solid #ccc; width: 300px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); z-index: 1000;">
                    
                    <div style="padding: 10px; border-bottom: 1px solid #eee; font-weight: bold;">
                        Notifications
                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <a href="{{ route('notifications.read') }}" style="float: right; font-size: 12px; color: blue; text-decoration: none;">Mark all read</a>
                        @endif
                    </div>

                    <ul style="list-style: none; margin: 0; padding: 0; max-height: 300px; overflow-y: auto;">
                        @forelse(auth()->user()->unreadNotifications as $notification)
                            <li style="padding: 10px; border-bottom: 1px solid #eee; font-size: 14px;">
                                {{-- Assuming your notification sends a message in 'data' --}}
                                {{ $notification->data['message'] ?? 'New Notification' }}
                                <br>
                                <small style="color: #888;">{{ $notification->created_at->diffForHumans() }}</small>
                            </li>
                        @empty
                            <li style="padding: 10px; color: #888; text-align: center;">No new notifications</li>
                        @endforelse
                    </ul>
                </div>

            </div>

            {{-- Logout Link (Optional but good to have) --}}
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" style="cursor: pointer;">Logout</button>
            </form>
        @else
            <a href="{{ route('login') }}">Login</a>
        @endauth

    </div>
</div>

{{-- SIMPLE SCRIPT TO TOGGLE DROPDOWN --}}
<style>
    .show { display: block !important; }
</style>
{{-- END OF NOTIFICATION BAR --}}

<h1>Available Properties</h1>

@if(session('success'))
    <p style="color: green">{{ session('success') }}</p>
@endif

@if(session('error'))
    <p style="color: red">{{ session('error') }}</p>
@endif

<table border="1" cellpadding="10">
    <tr>
        <th>Images</th>
        <th>Title</th>
        <th>Rent</th>
        <th>Address</th>
        <th>Status</th>
        <th>Details</th>
    </tr>

    @foreach($properties as $property)
    <tr>

        {{-- SHOW IMAGES --}}
        <td>
            @php
                // FIX: ensure images is always an array
                $images = is_array($property->images)
                        ? $property->images
                        : (json_decode($property->images, true) ?? []);
            @endphp

            @if(!empty($images))
                @foreach($images as $img)
                    <img src="{{ asset('storage/property_images/'.$img) }}"
                        width="80" height="80"
                        style="object-fit:cover; margin-right:5px;">
                @endforeach
            @else
                <i>No Images</i>
            @endif
        </td>

        <td>{{ $property->title }}</td>
        <td>{{ $property->rent_price }}</td>
        <td>{{ $property->address }}</td>

        <td>
            @if($property->availability == 1)
                <span style="color: green">Available</span>
            @else
                <span style="color: red">Booked</span>
            @endif
        </td>

        <td>
            <a href="/properties/{{ $property->id }}">View</a>
        </td>
    </tr>
    @endforeach
</table>

</body>
</html>
