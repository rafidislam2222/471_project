<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Owner Dashboard</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root{
            --bg: #0b1220;
            --border: rgba(255,255,255,0.12);
            --text: #e5e7eb;
            --muted: rgba(229,231,235,0.72);

            --accent: #7c3aed;
            --accent2:#22c55e;
            --danger:#ef4444;

            --shadow: 0 20px 60px rgba(0,0,0,0.35);
            --shadow2: 0 12px 30px rgba(0,0,0,0.25);

            --radius-xl: 22px;
            --radius-lg: 18px;
        }

        *{ box-sizing:border-box; }
        body{
            margin:0;
            font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, "Apple Color Emoji","Segoe UI Emoji";
            color: var(--text);
            background:
                radial-gradient(900px 450px at 12% 8%, rgba(124,58,237,.35), transparent 60%),
                radial-gradient(800px 420px at 96% 12%, rgba(34,197,94,.22), transparent 55%),
                radial-gradient(1100px 550px at 50% 120%, rgba(59,130,246,.16), transparent 60%),
                var(--bg);
            min-height: 100vh;
        }
        a{ text-decoration:none; color:inherit; }
        button{ font-family:inherit; }

        .wrap{
            max-width: 1320px;
            margin: 26px auto;
            padding: 0 18px 26px;
        }

        .main{
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.10);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow);
            overflow:hidden;
            position: relative;
        }

        /* Top bar */
        .topbar{
            padding: 16px 18px;
            display:flex;
            justify-content:space-between;
            align-items:center;
            gap: 14px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            background: rgba(255,255,255,0.04);
            backdrop-filter: blur(10px);
            min-height: 84px;
        }

        .welcome h2{
            margin:0;
            font-size: 18px;
            letter-spacing:.2px;
        }
        .welcome p{
            margin:5px 0 0;
            font-size: 13px;
            color: var(--muted);
        }

        /* Buttons (top-right) */
        .top-actions{
            display:flex;
            align-items:center;
            gap:10px;
            z-index: 50;
        }

        .btn{
            display:inline-flex;
            align-items:center;
            gap:9px;
            padding: 10px 12px;
            border-radius: 14px;
            border: 1px solid rgba(255,255,255,0.12);
            background: rgba(255,255,255,0.06);
            color: var(--text);
            font-weight: 700;
            font-size: 13px;
            cursor:pointer;
            transition: transform .15s ease, background .15s ease, border-color .15s ease;
        }
        .btn:hover{
            transform: translateY(-1px);
            background: rgba(255,255,255,0.10);
            border-color: rgba(255,255,255,0.18);
        }

        .btn-danger{
            background: linear-gradient(135deg, rgba(239,68,68,1), rgba(220,38,38,1));
            border: none;
            color: #fff;
        }
        .btn-danger:hover{
            background: linear-gradient(135deg, rgba(220,38,38,1), rgba(185,28,28,1));
        }

        .icon-btn{
            width:44px; height:44px;
            padding:0;
            border-radius: 14px;
            display:grid; place-items:center;
            position: relative;
        }

        /* Notification badge */
        .badge{
            position:absolute;
            top:-6px; right:-6px;
            min-width: 18px;
            height: 18px;
            padding: 0 6px;
            border-radius: 999px;
            background: var(--danger);
            color:#fff;
            font-size: 11px;
            font-weight: 800;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            border: 2px solid rgba(11,18,32,1);
        }

        /* ✅ FIX: Dropdown is now fixed to viewport (top-right), not inside the main box */
        .notif-dropdown{
            display:none;
            position: fixed;
            right: 24px;
            top: 96px;
            width: 420px;
            background: rgba(12,18,34,0.92);
            border: 1px solid rgba(255,255,255,0.14);
            border-radius: 16px;
            box-shadow: 0 24px 70px rgba(0,0,0,.55);
            overflow:hidden;
            z-index: 999999;
            backdrop-filter: blur(14px);
        }
        .notif-header{
            padding: 12px 14px;
            display:flex;
            align-items:center;
            justify-content:space-between;
            border-bottom: 1px solid rgba(255,255,255,0.10);
            background: rgba(255,255,255,0.05);
            font-weight: 800;
            font-size: 13px;
        }
        .notif-body{ max-height: 340px; overflow-y:auto; }
        .notif-item{
            display:flex;
            gap:10px;
            padding: 12px 14px;
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }
        .notif-item:hover{ background: rgba(255,255,255,0.05); }
        .notif-dot{
            width:10px; height:10px;
            margin-top: 4px;
            border-radius:999px;
            background: var(--accent);
            flex:0 0 auto;
        }
        .notif-text strong{
            display:block;
            font-size: 13px;
            margin-bottom: 2px;
        }
        .notif-text small{
            display:block;
            font-size: 12px;
            color: rgba(229,231,235,0.65);
        }

        /* Content area */
        .content{ padding: 18px; }

        .stats{
            display:grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 12px;
        }
        .stat{
            grid-column: span 6;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.10);
            border-radius: 18px;
            padding: 14px;
            display:flex;
            align-items:center;
            justify-content:space-between;
            box-shadow: 0 12px 30px rgba(0,0,0,.18);
        }
        .stat .left{
            display:flex;
            gap:12px;
            align-items:center;
        }
        .stat .bubble{
            width:44px; height:44px;
            border-radius: 16px;
            display:grid; place-items:center;
            background: rgba(124,58,237,0.18);
            border: 1px solid rgba(124,58,237,0.30);
        }
        .stat .bubble.green{
            background: rgba(34,197,94,0.16);
            border-color: rgba(34,197,94,0.28);
        }
        .stat strong{ display:block; font-size: 13px; }
        .stat span{
            display:block;
            font-size: 12px;
            color: var(--muted);
            margin-top: 2px;
        }
        .stat .pill{
            font-size: 12px;
            font-weight: 800;
            padding: 7px 10px;
            border-radius: 999px;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.12);
            color: rgba(229,231,235,0.9);
        }

        .actions{
            margin-top: 14px;
            display:grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 12px;
        }

        .action-card{
            grid-column: span 6;
            background: linear-gradient(135deg, rgba(255,255,255,0.06), rgba(255,255,255,0.03));
            border: 1px solid rgba(255,255,255,0.10);
            border-radius: 20px;
            padding: 16px;
            box-shadow: 0 18px 50px rgba(0,0,0,.20);
            position:relative;
            overflow:hidden;
        }
        .action-card:before{
            content:"";
            position:absolute;
            inset:auto -120px -120px auto;
            width: 240px;
            height: 240px;
            border-radius: 999px;
            background: radial-gradient(circle at 30% 30%, rgba(124,58,237,.35), transparent 60%);
            opacity:.7;
        }

        .action-title{
            display:flex;
            gap:12px;
            align-items:center;
        }
        .action-icon{
            width:48px; height:48px;
            border-radius: 18px;
            display:grid; place-items:center;
            color:#fff;
            flex: 0 0 auto;
        }
        .action-icon.green{
            background: linear-gradient(135deg, rgba(34,197,94,1), rgba(16,185,129,1));
        }
        .action-icon.blue{
            background: linear-gradient(135deg, rgba(59,130,246,1), rgba(124,58,237,1));
        }
        .action-card h3{
            margin:0;
            font-size: 15px;
            letter-spacing:.2px;
        }
        .action-card p{
            margin: 8px 0 14px;
            font-size: 13px;
            color: rgba(229,231,235,0.72);
            line-height: 1.45;
            max-width: 520px;
        }

        .primary{
            background: linear-gradient(135deg, rgba(124,58,237,1), rgba(59,130,246,1));
            border: none;
        }
        .primary:hover{
            background: linear-gradient(135deg, rgba(99,102,241,1), rgba(59,130,246,1));
        }
        .success{
            background: linear-gradient(135deg, rgba(34,197,94,1), rgba(16,185,129,1));
            border: none;
        }
        .success:hover{
            background: linear-gradient(135deg, rgba(22,163,74,1), rgba(16,185,129,1));
        }

        /* ✅ Responsive */
        @media (max-width: 900px){
            .notif-dropdown{ width: 92vw; max-width: 440px; right: 12px; }
        }
        @media (max-width: 760px){
            .stat{ grid-column: span 12; }
            .action-card{ grid-column: span 12; }
            .topbar{ flex-direction:column; align-items:flex-start; }
            .top-actions{ width:100%; justify-content:flex-end; }
            .notif-dropdown{ top: 140px; } /* below stacked header */
        }
    </style>
</head>
<body>

<div class="wrap">
    <main class="main">

        <div class="topbar">
            <div class="welcome">
                <h2>Owner Dashboard</h2>
                <p>Welcome back! Manage your listings and notifications.</p>
            </div>

            <!-- Top-right buttons -->
            <div class="top-actions">
                <button class="btn icon-btn" id="notifBtn" type="button" onclick="toggleDropdown()" aria-label="Notifications">
                    <i class="fa-regular fa-bell"></i>

                    @if(auth()->user()->unreadNotifications->count() > 0)
                        <span class="badge" id="notifBadge">{{ auth()->user()->unreadNotifications->count() }}</span>
                    @endif
                </button>

                <a class="btn btn-danger" href="/logout">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    Logout
                </a>
            </div>
        </div>

        <!-- ✅ Dropdown moved OUTSIDE cards (fixed top-right) -->
        <div class="notif-dropdown" id="notificationBox">
            <div class="notif-header">
                <span><i class="fa-regular fa-bell"></i> Notifications</span>
                <span style="color: rgba(229,231,235,0.70); font-weight:700; font-size:12px;">
                    Unread: {{ auth()->user()->unreadNotifications->count() }}
                </span>
            </div>

            <div class="notif-body">
                @forelse(auth()->user()->unreadNotifications as $notification)
                    <a href="{{ $notification->data['url'] ?? '#' }}" class="notif-item">
                        <span class="notif-dot"></span>
                        <span class="notif-text">
                            <strong>{{ $notification->data['message'] }}</strong>
                            <small>{{ $notification->created_at->diffForHumans() }}</small>
                        </span>
                        <i class="fa-solid fa-chevron-right" style="color: rgba(229,231,235,0.35); margin-left:6px;"></i>
                    </a>
                @empty
                    <div style="padding:18px; text-align:center; color: rgba(229,231,235,0.70);">
                        <i class="fa-regular fa-face-smile" style="font-size:20px;"></i>
                        <div style="margin-top:8px; font-weight:900; color: rgba(229,231,235,0.92);">All caught up</div>
                        <div style="margin-top:4px; font-size:13px;">No new notifications right now.</div>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="content">
            <div class="stats">
                <div class="stat">
                    <div class="left">
                        <div class="bubble">
                            <i class="fa-solid fa-house"></i>
                        </div>
                        <div>
                            <strong>Your Listings</strong>
                            <span>Manage and update your properties</span>
                        </div>
                    </div>
                    <div class="pill">Owner</div>
                </div>

                <div class="stat">
                    <div class="left">
                        <div class="bubble green">
                            <i class="fa-solid fa-shield-heart"></i>
                        </div>
                        <div>
                            <strong>Notifications</strong>
                            <span>Stay updated with bookings</span>
                        </div>
                    </div>
                    <div class="pill">Live</div>
                </div>
            </div>

            <div class="actions">
                <div class="action-card">
                    <div class="action-title">
                        <div class="action-icon green">
                            <i class="fa-solid fa-circle-plus"></i>
                        </div>
                        <div>
                            <h3>Add New Property</h3>
                            <p>Create a polished listing with photos, location, and pricing to attract renters faster.</p>
                        </div>
                    </div>

                    <a class="btn success" href="/owner/properties/create">
                        <i class="fa-solid fa-plus"></i>
                        Create Listing
                    </a>
                </div>

                <div class="action-card">
                    <div class="action-title">
                        <div class="action-icon blue">
                            <i class="fa-solid fa-table-list"></i>
                        </div>
                        <div>
                            <h3>Show My Properties</h3>
                            <p>View, edit, and manage availability. Keep your portfolio organized in one place.</p>
                        </div>
                    </div>

                    <a class="btn primary" href="/owner/properties">
                        <i class="fa-solid fa-list"></i>
                        View Listings
                    </a>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
    function toggleDropdown() {
        const box = document.getElementById("notificationBox");
        const badge = document.getElementById("notifBadge");

        const isOpen = (box.style.display === "block");
        box.style.display = isOpen ? "none" : "block";

        if (!isOpen) {
            if (badge) badge.style.display = 'none';
            fetch("{{ route('markAsRead') }}").catch(() => {});
        }
    }

    window.addEventListener('click', function(event) {
        const notifBtn = document.getElementById('notifBtn');
        const box = document.getElementById("notificationBox");

        // if click is outside both the button and the dropdown -> close
        if (box && !box.contains(event.target) && notifBtn && !notifBtn.contains(event.target)) {
            box.style.display = "none";
        }
    });
</script>

</body>
</html>
