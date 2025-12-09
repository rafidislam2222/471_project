<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>User Management</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>

<div class="screen">
    {{-- Top bar --}}
    <div class="topbar">
        <div class="topbar-title">User Management</div>
        <div class="topbar-right">
            Admin User
        </div>
    </div>

    <div class="page-inner">
        {{-- Search + filters row --}}
        <div class="toolbar">
            {{-- SEARCH FORM --}}
            <form class="search-box" action="{{ route('admin.users.index') }}" method="GET">
                {{-- keep current role filter when searching --}}
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

</body>
</html>
