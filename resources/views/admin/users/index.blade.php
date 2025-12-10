<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>User Management</title>
    <link rel="stylesheet" href="/css/style.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* Container for the right side of the topbar */
        .topbar-right {
            display: flex;
            align-items: center;
        }

        /* --- Notification Styles --- */
        .notification-wrapper {
            position: relative;
            cursor: pointer;
            margin-right: 20px; /* Space between bell and "ADMIN" text */
        }
        .bell-icon {
            font-size: 20px;
            color: #555;
            transition: color 0.3s;
        }
        .bell-icon:hover { color: #000; }

        /* The Red Badge */
        .badge-notif {
            position: absolute;
            top: -6px;
            right: -6px;
            background-color: red;
            color: white;
            border-radius: 50%;
            padding: 2px 5px;
            font-size: 10px;
            font-weight: bold;
        }

        /* The Dropdown Box */
        .notif-dropdown {
            display: none; /* Hidden by default */
            position: absolute;
            right: 0;
            top: 30px;
            width: 320px;
            background-color: white;
            border: 1px solid #ccc;
            box-shadow: 0px 4px 10px rgba(0,0,0,0.15);
            z-index: 1000;
            border-radius: 6px;
            text-align: left; /* Reset text alignment */
        }
        .notif-header {
            background-color: #f8f9fa;
            padding: 10px;
            border-bottom: 1px solid #eee;
            font-weight: bold;
            color: #333;
            font-size: 14px;
        }
        .notif-item {
            padding: 12px;
            border-bottom: 1px solid #f1f1f1;
            font-size: 13px;
            display: block;
            text-decoration: none;
            color: #333;
            line-height: 1.4;
        }
        .notif-item:hover { background-color: #f0f2f5; }
        .notif-time {
            display: block;
            font-size: 11px;
            color: #888;
            margin-top: 4px;
        }
    </style>
</head>
<body>

<div class="screen">
    {{-- Top bar --}}
    <div class="topbar">
        <div class="topbar-title">User Management</div>
             
        <div class="topbar-right">
            <div class="notification-wrapper" onclick="toggleDropdown()">
                <i class="fas fa-bell bell-icon"></i>
                
                @if(auth()->user()->unreadNotifications->count() > 0)
                    <span class="badge-notif" id="notifBadge">{{ auth()->user()->unreadNotifications->count() }}</span>
                @endif
        
                <div class="notif-dropdown" id="notificationBox">
                    <div class="notif-header">
                        Notifications
                    </div>
        
                    <div style="max-height: 300px; overflow-y: auto;">
                        @forelse(auth()->user()->unreadNotifications as $notification)
                            <a href="{{ $notification->data['url'] ?? '#' }}" class="notif-item">
                                <strong>{{ $notification->data['message'] }}</strong> <br>
                                <span class="notif-time">{{ $notification->created_at->diffForHumans() }}</span>
                            </a>
                        @empty
                            <div style="padding:20px; text-align:center; color:gray; font-size:13px;">No new notifications</div>
                        @endforelse
                    </div>
                </div>
            </div>
            <span style="font-weight: bold;">ADMIN</span>
                
            <span style="margin: 0 10px; color: #ccc;">|</span>

            <a href="{{ url('/logout') }}" 
                style="color: red; text-decoration: none; font-weight: bold; font-size: 14px;">
                Logout ➜
            </a>
        </div>
    </div>

    <div class="page-inner">
        {{-- Search + filters row --}}
        <div class="toolbar">
            {{-- SEARCH FORM --}}
            <form class="search-box" action="{{ route('admin.users.index') }}" method="GET">
                @if(!empty($currentRole))
                    <input type="hidden" name="role" value="{{ $currentRole }}">
                @endif

                <input
                    class="search-input"
                    type="text"
                    name="search"
                    value="{{ $search ?? '' }}"
                    placeholder="Search by Name, Email or ID..."
                >
            </form>

            {{-- ROLE FILTER BUTTONS --}}
            <div class="filter-buttons">
                <a href="{{ route('admin.users.index', ['role' => 'admin']) }}"
                   class="filter-btn {{ ($currentRole ?? null) === 'admin' ? 'filter-btn-active' : '' }}">
                    Admins
                </a>

                <a href="{{ route('admin.users.index', ['role' => 'owner']) }}"
                   class="filter-btn {{ ($currentRole ?? null) === 'owner' ? 'filter-btn-active' : '' }}">
                    Owners
                </a>

                <a href="{{ route('admin.users.index', ['role' => 'user']) }}"
                   class="filter-btn {{ ($currentRole ?? null) === 'user' ? 'filter-btn-active' : '' }}">
                    Users
                </a>
            </div>
        </div>

        {{-- Flash message --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Main table block --}}
        <div class="table-shell">
            <table class="user-table">
                <thead>
                <tr>
                    <th>User Info</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Suspended Until</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($users as $user)
                    @php
                        $roleClass = 'badge-role-user';
                        if ($user->role === 'admin') {
                            $roleClass = 'badge-role-admin';
                        } elseif ($user->role === 'owner') {
                            $roleClass = 'badge-role-owner';
                        }
                    @endphp
                    <tr>
                        {{-- User info --}}
                        <td>
                            <div class="user-main">{{ $user->name }}</div>
                            <div class="user-sub">{{ $user->email }}</div>
                        </td>

                        {{-- Role badge --}}
                        <td>
                            <span class="badge {{ $roleClass }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>

                        {{-- Status badge --}}
                        <td>
                            @if($user->status === 'suspended')
                                <span class="badge badge-status-suspended">Suspended</span>
                            @else
                                <span class="badge badge-status-active">Active</span>
                            @endif
                        </td>

                        {{-- Suspended until --}}
                        <td>
                            {{ $user->suspended_until ?? '-' }}
                        </td>

                        {{-- Actions --}}
                        <td>
                            <div class="actions">
                                {{-- View profile --}}
                                <a href="{{ route('admin.users.profile', $user) }}"
                                   class="btn btn-sm btn-primary">
                                    Profile
                                </a>

                                {{-- Change role --}}
                                <form action="{{ route('admin.users.updateRole', $user) }}"
                                      method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <select name="role">
                                        <option value="user"  {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                                        <option value="owner" {{ $user->role == 'owner' ? 'selected' : '' }}>Owner</option>
                                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                    </select>
                                    <button type="submit" class="btn btn-sm">Save</button>
                                </form>

                                {{-- Suspend / unsuspend --}}
                                <form action="{{ route('admin.users.suspend', $user) }}"
                                      method="POST">
                                    @csrf
                                    <select name="type">
                                        <option value="none">Remove</option>
                                        <option value="temporary">Temporary</option>
                                        <option value="permanent">Permanent</option>
                                    </select>
                                    <input type="number" name="days" placeholder="Days" min="1">
                                    <button type="submit" class="btn btn-sm">Apply</button>
                                </form>

                                {{-- Delete --}}
                                <form action="{{ route('admin.users.destroy', $user) }}"
                                      method="POST"
                                      onsubmit="return confirm('Delete this user permanently?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">No users found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <p class="info-text">
            <a href="/admin/dashboard">← Back to Dashboard</a>
        </p>
    </div>
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