<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile | {{ $user->name }}</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #4F46E5;
            --primary-hover: #4338ca;
            --bg-body: #f3f4f6;
            --surface: #ffffff;
            --text-main: #1f2937;
            --text-sub: #6b7280;
            --danger: #ef4444;
            --success: #10b981;
            --border: #e5e7eb;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background-color: var(--bg-body); color: var(--text-main); padding-bottom: 40px; }

        /* --- Topbar --- */
        .topbar {
            background: var(--surface); height: 64px; padding: 0 30px;
            display: flex; align-items: center; justify-content: space-between;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); position: sticky; top: 0; z-index: 50;
        }
        .topbar-title { font-size: 18px; font-weight: 600; color: var(--text-main); }
        .back-link { text-decoration: none; color: var(--text-sub); font-size: 14px; font-weight: 500; display: flex; align-items: center; gap: 5px; transition: 0.2s; }
        .back-link:hover { color: var(--primary); }

        /* --- Profile Container --- */
        .profile-container { max-width: 800px; margin: 40px auto; padding: 0 20px; }

        /* --- Main Card --- */
        .profile-card {
            background: var(--surface); border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05); overflow: hidden;
        }

        /* Header Section (Banner) */
        .profile-header {
            background: linear-gradient(135deg, var(--primary), #818cf8);
            height: 120px; position: relative;
        }
        
        /* Avatar Area */
        .profile-avatar-wrapper {
            position: absolute; bottom: -40px; left: 40px;
            width: 100px; height: 100px;
            background: white; border-radius: 50%; padding: 4px;
        }
        .profile-avatar {
            width: 100%; height: 100%; background: #e0e7ff; color: var(--primary);
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-size: 36px; font-weight: 700; text-transform: uppercase;
        }

        /* Info Section */
        .profile-body { padding: 50px 40px 40px 40px; }
        
        .user-name { font-size: 24px; font-weight: 700; margin-bottom: 4px; }
        .user-email { color: var(--text-sub); font-size: 14px; margin-bottom: 20px; display: flex; align-items: center; gap: 6px; }

        .badges-row { display: flex; gap: 10px; margin-bottom: 30px; }
        .badge { padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; text-transform: uppercase; }
        .badge-role { background: #e0e7ff; color: #3730a3; }
        .badge-status { background: #d1fae5; color: #065f46; }
        .badge-suspended { background: #fef3c7; color: #92400e; }

        /* Grid Details */
        .details-grid {
            display: grid; grid-template-columns: 1fr 1fr; gap: 20px;
            background: #f9fafb; padding: 20px; border-radius: 12px; border: 1px solid var(--border);
        }
        .detail-item { display: flex; flex-direction: column; }
        .detail-label { font-size: 11px; text-transform: uppercase; color: var(--text-sub); font-weight: 600; margin-bottom: 4px; }
        .detail-value { font-size: 14px; font-weight: 500; color: var(--text-main); }

        /* --- Admin Actions Section --- */
        .actions-section {
            margin-top: 30px; padding-top: 30px; border-top: 1px solid var(--border);
        }
        .section-title { font-size: 16px; font-weight: 600; margin-bottom: 15px; color: var(--text-main); }
        
        .action-box {
            background: white; border: 1px solid var(--border); border-radius: 8px;
            padding: 15px; margin-bottom: 15px;
            display: flex; align-items: center; justify-content: space-between;
        }
        .action-info h4 { font-size: 14px; margin-bottom: 2px; }
        .action-info p { font-size: 12px; color: var(--text-sub); }

        /* Form Elements */
        select, input[type="number"] {
            padding: 8px 12px; border: 1px solid var(--border); border-radius: 6px;
            font-size: 13px; outline: none; background: #fff;
        }
        .btn {
            padding: 8px 16px; border-radius: 6px; font-size: 13px; font-weight: 500;
            cursor: pointer; border: none; transition: 0.2s; text-decoration: none;
        }
        .btn-primary { background: var(--primary); color: white; }
        .btn-primary:hover { background: var(--primary-hover); }
        
        .btn-danger { background: white; border: 1px solid #fee2e2; color: var(--danger); }
        .btn-danger:hover { background: var(--danger); color: white; border-color: var(--danger); }

    </style>
</head>
<body>

    <div class="topbar">
        <div class="topbar-title">Admin Dashboard</div>
        <a href="{{ route('admin.users.index') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>

    <div class="profile-container">

        @if(session('success'))
            <div style="background: #d1fae5; color: #065f46; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 14px;">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <div class="profile-card">
            <div class="profile-header">
                <div class="profile-avatar-wrapper">
                    <div class="profile-avatar">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                </div>
            </div>

            <div class="profile-body">
                <div class="user-name">{{ $user->name }}</div>
                <div class="user-email"><i class="far fa-envelope"></i> {{ $user->email }}</div>

                <div class="badges-row">
                    <span class="badge badge-role">{{ ucfirst($user->role) }}</span>
                    
                    @if($user->status === 'suspended')
                        <span class="badge badge-suspended">Suspended</span>
                    @else
                        <span class="badge badge-status">Active Account</span>
                    @endif
                </div>

                <div class="details-grid">
                    <div class="detail-item">
                        <span class="detail-label">User ID</span>
                        <span class="detail-value">#{{ $user->id }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Joined On</span>
                        <span class="detail-value">{{ $user->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Last Updated</span>
                        <span class="detail-value">{{ $user->updated_at->diffForHumans() }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Suspension Status</span>
                        <span class="detail-value">
                            {{ $user->suspended_until ? 'Suspended until ' . date('M d', strtotime($user->suspended_until)) : 'None' }}
                        </span>
                    </div>
                </div>

                <div class="actions-section">
                    <div class="section-title">Admin Management Actions</div>

                    <div class="action-box">
                        <div class="action-info">
                            <h4>Change User Role</h4>
                            <p>Promote or demote this user.</p>
                        </div>
                        <form action="{{ route('admin.users.updateRole', $user->id) }}" method="POST" style="display:flex; gap:10px;">
                            @csrf @method('PATCH')
                            <select name="role">
                                <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                                <option value="owner" {{ $user->role == 'owner' ? 'selected' : '' }}>Owner</option>
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>

                    <div class="action-box">
                        <div class="action-info">
                            <h4>Suspension & Ban</h4>
                            <p>Restrict access temporarily or permanently.</p>
                        </div>
                        <form action="{{ route('admin.users.suspend', $user->id) }}" method="POST" style="display:flex; gap:10px;">
                            @csrf
                            <select name="type">
                                <option value="none">Unban (Active)</option>
                                <option value="temporary">7 Days</option>
                                <option value="permanent">Permanent</option>
                            </select>
                            <input type="hidden" name="days" value="7"> 
                            <button type="submit" class="btn btn-primary" style="background:#f59e0b;">Apply</button>
                        </form>
                    </div>

                    <div class="action-box" style="border-color: #fee2e2; background: #fef2f2;">
                        <div class="action-info">
                            <h4 style="color: #991b1b;">Delete Account</h4>
                            <p style="color: #b91c1c;">Permanently remove this user and their data.</p>
                        </div>
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user? This cannot be undone.');">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete User</button>
                        </form>
                    </div>

                </div>

            </div>
        </div>
    </div>

</body>
</html>