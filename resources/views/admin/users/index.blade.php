<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | User Management</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #4F46E5; /* Indigo */
            --primary-hover: #4338ca;
            --bg-body: #f3f4f6;
            --surface: #ffffff;
            --text-main: #1f2937;
            --text-sub: #6b7280;
            --danger: #ef4444;
            --success: #10b981;
            --warning: #f59e0b;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        
        body { background-color: var(--bg-body); color: var(--text-main); }

        /* --- Topbar --- */
        .topbar {
            background: var(--surface);
            height: 64px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 30px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .topbar-title {
            font-size: 20px;
            font-weight: 700;
            color: var(--primary);
            letter-spacing: -0.5px;
        }

        .topbar-right { display: flex; align-items: center; gap: 20px; }

        .admin-label { font-size: 13px; font-weight: 600; color: var(--text-main); background: #e0e7ff; padding: 4px 12px; border-radius: 20px; color: var(--primary); }

        .logout-link {
            color: var(--text-sub);
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            transition: 0.2s;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .logout-link:hover { color: var(--danger); }

        /* --- Notifications --- */
        .notification-wrapper { position: relative; cursor: pointer; }
        .bell-icon { font-size: 20px; color: var(--text-sub); transition: 0.2s; }
        .bell-icon:hover { color: var(--primary); transform: scale(1.1); }
        
        .badge-notif {
            position: absolute; top: -5px; right: -5px;
            background: var(--danger); color: white;
            border-radius: 50%; width: 18px; height: 18px;
            font-size: 10px; font-weight: bold;
            display: flex; align-items: center; justify-content: center;
            border: 2px solid var(--surface);
        }

        .notif-dropdown {
            display: none; position: absolute; right: -10px; top: 40px;
            width: 320px; background: white;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            border: 1px solid #e5e7eb;
            z-index: 100; overflow: hidden;
            animation: fadeIn 0.2s ease-out;
        }
        @keyframes fadeIn { from { opacity:0; transform:translateY(-10px); } to { opacity:1; transform:translateY(0); } }

        .notif-header { background: #f9fafb; padding: 12px 16px; font-weight: 600; border-bottom: 1px solid #e5e7eb; font-size: 14px; }
        .notif-item { padding: 12px 16px; border-bottom: 1px solid #f3f4f6; display: block; text-decoration: none; color: #374151; transition: 0.2s; }
        .notif-item:hover { background: #f9fafb; padding-left: 20px; }
        .notif-time { font-size: 11px; color: #9ca3af; margin-top: 4px; display: block; }

        /* --- Main Layout --- */
        .container { max-width: 1200px; margin: 30px auto; padding: 0 20px; }

        /* --- Toolbar (Search + Filter) --- */
        .toolbar {
            display: flex; justify-content: space-between; align-items: center;
            background: var(--surface); padding: 15px 20px;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            margin-bottom: 25px;
        }

        .search-box { position: relative; width: 400px; }
        .search-input {
            width: 100%; padding: 10px 15px 10px 40px;
            border: 1px solid #e5e7eb; border-radius: 8px;
            font-size: 14px; outline: none; transition: 0.2s;
            background-color: #f9fafb;
        }
        .search-input:focus { border-color: var(--primary); background: white; box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1); }
        .search-icon { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 14px; }

        .filter-buttons { display: flex; gap: 8px; background: #f3f4f6; padding: 4px; border-radius: 8px; }
        .filter-btn {
            padding: 6px 16px; font-size: 13px; font-weight: 500;
            text-decoration: none; color: var(--text-sub);
            border-radius: 6px; transition: 0.2s;
        }
        .filter-btn:hover { color: var(--text-main); }
        .filter-btn-active { background: white; color: var(--primary); box-shadow: 0 1px 2px rgba(0,0,0,0.05); font-weight: 600; }

        /* --- Table --- */
        .table-card { background: var(--surface); border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); overflow: hidden; }
        .user-table { width: 100%; border-collapse: collapse; text-align: left; }
        
        .user-table th {
            background: #f9fafb; padding: 16px;
            font-size: 12px; font-weight: 600; text-transform: uppercase; color: var(--text-sub); letter-spacing: 0.5px;
        }
        .user-table td { padding: 16px; border-bottom: 1px solid #f3f4f6; vertical-align: middle; font-size: 14px; }
        .user-table tr:last-child td { border-bottom: none; }
        .user-table tr:hover td { background: #f9fafb; }

        .user-main { font-weight: 600; color: var(--text-main); }
        .user-sub { font-size: 12px; color: var(--text-sub); margin-top: 2px; }

        /* --- Badges --- */
        .badge { padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; text-transform: uppercase; display: inline-block; }
        .badge-role-admin { background: #fee2e2; color: #991b1b; } /* Red */
        .badge-role-owner { background: #e0e7ff; color: #3730a3; } /* Indigo */
        .badge-role-user { background: #f3f4f6; color: #374151; } /* Gray */
        
        .badge-status-active { background: #d1fae5; color: #065f46; } /* Green */
        .badge-status-suspended { background: #fef3c7; color: #92400e; } /* Amber */

        /* --- Actions Column --- */
        .actions { display: flex; align-items: center; gap: 10px; }
        
        /* New "Manage" Button */
        .btn-manage {
            background-color: var(--primary);
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: 0.2s;
            box-shadow: 0 2px 4px rgba(79, 70, 229, 0.2);
        }
        .btn-manage:hover {
            background-color: var(--primary-hover);
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(79, 70, 229, 0.3);
        }

        .btn-icon-danger {
            width: 32px; height: 32px;
            display: flex; align-items: center; justify-content: center;
            background: white; border: 1px solid #fee2e2; color: var(--danger);
            border-radius: 6px; cursor: pointer; transition: 0.2s;
        }
        .btn-icon-danger:hover {
            background: var(--danger); color: white; border-color: var(--danger);
        }

        /* Pagination */
        .pagination { display: inline-flex; gap: 5px; list-style: none; }
        .page-link { padding: 6px 12px; border: 1px solid #e5e7eb; border-radius: 6px; color: var(--text-main); text-decoration: none; font-size: 13px; }
        .page-item.active .page-link { background: var(--primary); color: white; border-color: var(--primary); }

    </style>
</head>
<body>

    <div class="topbar">
        <div class="topbar-title">
            <i class="fas fa-shield-alt" style="margin-right: 8px;"></i> Admin Panel
        </div>
        
        <div class="topbar-right">
            <div class="notification-wrapper" onclick="toggleDropdown()">
                <i class="fas fa-bell bell-icon"></i>
                @if(auth()->user()->unreadNotifications->count() > 0)
                    <span class="badge-notif" id="notifBadge">{{ auth()->user()->unreadNotifications->count() }}</span>
                @endif
        
                <div class="notif-dropdown" id="notificationBox">
                    <div class="notif-header">Recent Alerts</div>
                    <div style="max-height: 300px; overflow-y: auto;">
                        @forelse(auth()->user()->unreadNotifications as $notification)
                            <a href="{{ $notification->data['url'] ?? '#' }}" class="notif-item">
                                <div style="font-weight: 600; margin-bottom: 2px;">{{ $notification->data['message'] }}</div>
                                <span class="notif-time"><i class="far fa-clock"></i> {{ $notification->created_at->diffForHumans() }}</span>
                            </a>
                        @empty
                            <div style="padding:30px; text-align:center; color: #9ca3af; font-size:13px;">
                                <i class="far fa-bell-slash" style="font-size: 20px; margin-bottom: 5px;"></i><br>
                                No new notifications
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <span class="admin-label">SUPER ADMIN</span>
            
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="logout-link">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>

    <div class="container">
        
        <div class="toolbar">
            <form class="search-box" action="{{ route('admin.users.index') }}" method="GET">
                <i class="fas fa-search search-icon"></i>
                @if(!empty($currentRole))
                    <input type="hidden" name="role" value="{{ $currentRole }}">
                @endif
                
                <input class="search-input" type="text" name="search" id="liveSearch"
                       value="{{ $search ?? '' }}" placeholder="Start typing to search users..." autocomplete="off">
                
                <button type="submit" style="display: none;">Search</button>
            </form>

            <div class="filter-buttons">
                <a href="{{ route('admin.users.index', ['role' => 'admin']) }}" class="filter-btn {{ ($currentRole ?? null) === 'admin' ? 'filter-btn-active' : '' }}">Admins</a>
                <a href="{{ route('admin.users.index', ['role' => 'owner']) }}" class="filter-btn {{ ($currentRole ?? null) === 'owner' ? 'filter-btn-active' : '' }}">Owners</a>
                <a href="{{ route('admin.users.index', ['role' => 'user']) }}" class="filter-btn {{ ($currentRole ?? null) === 'user' ? 'filter-btn-active' : '' }}">Users</a>
                <a href="{{ route('admin.users.index') }}" class="filter-btn" style="color: var(--danger);" title="Clear Filters">×</a>
            </div>
        </div>

        @if(session('success'))
            <div style="background: #d1fae5; color: #065f46; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 14px;">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div style="background: #fee2e2; color: #991b1b; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 14px;">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        <div class="table-card">
            <table class="user-table">
                <thead>
                    <tr>
                        <th width="25%">User Details</th>
                        <th width="15%">Role</th>
                        <th width="15%">Status</th>
                        <th width="20%">Joined</th>
                        <th width="25%" style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($users as $user)
                    @php
                        $roleClass = 'badge-role-user';
                        if ($user->role === 'admin') $roleClass = 'badge-role-admin';
                        elseif ($user->role === 'owner') $roleClass = 'badge-role-owner';
                    @endphp
                    <tr>
                        <td>
                            <div class="user-main">{{ $user->name }}</div>
                            <div class="user-sub">{{ $user->email }}</div>
                        </td>
                        <td><span class="badge {{ $roleClass }}">{{ ucfirst($user->role) }}</span></td>
                        <td>
                            @if($user->status === 'suspended')
                                <span class="badge badge-status-suspended">Suspended</span>
                            @else
                                <span class="badge badge-status-active">Active</span>
                            @endif
                        </td>
                        <td style="font-size: 13px; color: #6b7280;">
                            {{ $user->created_at->format('M d, Y') }}
                        </td>
                        <td>
                            <div class="actions" style="justify-content: flex-end;">
                                <a href="{{ route('admin.users.profile', $user->id) }}" class="btn-manage">
                                    Manage User <i class="fas fa-arrow-right" style="font-size: 10px;"></i>
                                </a>

                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Delete this user permanently?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-icon-danger" title="Delete User">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center; padding: 40px; color: #9ca3af;">
                            No users found matching your search.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 20px; text-align: right;">
            {{ $users->links() }} 
        </div>

        <p class="info-text" style="margin-top: 20px;">
            <a href="/admin/dashboard" style="text-decoration:none; color: var(--text-sub); font-size:14px;">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </p>
    </div>

    <script>
        // 1. Notification Dropdown Logic
        function toggleDropdown() {
            var box = document.getElementById("notificationBox");
            var badge = document.getElementById("notifBadge");
            
            if (box.style.display === "none" || box.style.display === "") {
                box.style.display = "block";
                if (badge) badge.style.display = 'none';
                
                // Mark as Read via AJAX
                fetch("{{ route('markAsRead') }}").catch(err => console.error(err));
            } else {
                box.style.display = "none";
            }
        }

        // Close dropdown when clicking outside
        window.onclick = function(event) {
            if (!event.target.closest('.notification-wrapper')) {
                document.getElementById("notificationBox").style.display = "none";
            }
        }

        // 2. LIVE SEARCH LOGIC
        let timeout = null;
        const searchInput = document.getElementById('liveSearch');
        const searchForm = document.querySelector('.search-box');

        if(searchInput) {
            searchInput.addEventListener('input', function() {
                clearTimeout(timeout);
                timeout = setTimeout(function() {
                    searchForm.submit();
                }, 500); 
            });

            document.addEventListener("DOMContentLoaded", function() {
                const val = searchInput.value;
                if(val !== "") {
                    searchInput.focus();
                    searchInput.setSelectionRange(val.length, val.length);
                }
            });
        }
    </script>
</body>
</html>