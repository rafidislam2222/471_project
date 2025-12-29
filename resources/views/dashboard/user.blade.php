<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>User Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root{
            --bg: #0b1220;
            --text: #e5e7eb;
            --muted: rgba(229,231,235,0.78);

            /* ✅ increased opacity to improve readability */
            --panel: rgba(255,255,255,0.075);
            --panel2: rgba(255,255,255,0.10);
            --border: rgba(255,255,255,0.14);

            --purple: #7c3aed;
            --blue: #3b82f6;
            --green:#22c55e;
            --red:  #ef4444;

            --shadow: 0 20px 60px rgba(0,0,0,0.45);
            --shadow2: 0 12px 30px rgba(0,0,0,0.35);

            --r-xl: 22px;
            --r-lg: 16px;
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
            padding: 26px 16px 32px;
            position: relative;
        }

        /* ✅ dark overlay to stop gradients washing text */
        body::before{
            content:"";
            position: fixed;
            inset: 0;
            background: rgba(7, 10, 18, 0.55);
            pointer-events: none;
            z-index: 0;
        }

        a{ text-decoration:none; color:inherit; }

        .wrap{
            max-width: 1100px;
            margin: 0 auto;
            position: relative;
            z-index: 1; /* above overlay */
        }

        /* Top header card */
        .head{
            position: relative;
            background: var(--panel);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: var(--r-xl);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        /* ✅ make glow weaker so it doesn't ruin contrast */
        .head:before{
            content:"";
            position:absolute;
            inset:auto -180px -180px auto;
            width: 360px;
            height: 360px;
            border-radius: 999px;
            background: radial-gradient(circle at 30% 30%, rgba(124,58,237,.18), transparent 62%);
            opacity:.55;
        }

        .topbar{
            display:flex;
            align-items:flex-start;
            justify-content:space-between;
            gap: 12px;
            padding: 18px;
            border-bottom: 1px solid rgba(255,255,255,0.10);
            background: rgba(0,0,0,0.18);          /* ✅ darker header surface */
            backdrop-filter: blur(14px);
        }

        .titleblock h1{
            margin:0;
            font-size: 20px;
            letter-spacing: .2px;
            color: rgba(255,255,255,0.96);        /* ✅ stronger text */
        }

        .titleblock p{
            margin:6px 0 0;
            color: rgba(229,231,235,0.82);        /* ✅ stronger muted */
            font-size: 13px;
            line-height: 1.35;
        }

        .top-actions{
            display:flex;
            align-items:center;
            gap:10px;
            z-index: 2;
        }

        .btnx{
            display:inline-flex;
            align-items:center;
            gap:10px;
            padding: 10px 12px;
            border-radius: 14px;
            border: 1px solid rgba(255,255,255,0.16);
            background: rgba(0,0,0,0.22);         /* ✅ darker button bg */
            color: rgba(255,255,255,0.95);
            font-weight: 800;
            font-size: 13px;
            cursor:pointer;
            transition: transform .15s ease, background .15s ease, border-color .15s ease;
            backdrop-filter: blur(12px);
            user-select:none;
        }
        .btnx:hover{
            transform: translateY(-1px);
            background: rgba(0,0,0,0.32);
            border-color: rgba(255,255,255,0.24);
        }

        .btn-dangerx{
            border:none;
            background: linear-gradient(135deg, rgba(239,68,68,1), rgba(220,38,38,1));
            color:#fff;
        }
        .btn-dangerx:hover{
            background: linear-gradient(135deg, rgba(220,38,38,1), rgba(185,28,28,1));
        }

        .icon-btn{
            width:44px; height:44px;
            padding:0;
            border-radius: 14px;
            display:grid;
            place-items:center;
        }

        /* Notification */
        .notification-wrapper{ position: relative; }
        .bell{ font-size: 18px; line-height: 1; }

        .badge-count{
            position:absolute;
            top:-6px;
            right:-6px;
            min-width: 18px;
            height: 18px;
            padding: 0 6px;
            border-radius: 999px;
            background: var(--red);
            color: #fff;
            font-size: 11px;
            font-weight: 900;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            border: 2px solid rgba(11,18,32,1);
        }

        /* Body content inside header */
        .hero{ padding: 18px; }

        .hero-grid{
            display:grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 12px;
        }

        .card{
            grid-column: span 6;
            background: rgba(0,0,0,0.25);          /* ✅ darker card bg */
            border: 1px solid rgba(255,255,255,0.14);
            border-radius: 20px;
            box-shadow: var(--shadow2);
            padding: 16px;
            position:relative;
            overflow:hidden;
        }

        /* ✅ soften glow inside cards */
        .card:before{
            content:"";
            position:absolute;
            inset:auto -140px -140px auto;
            width: 260px;
            height: 260px;
            border-radius: 999px;
            background: radial-gradient(circle at 30% 30%, rgba(59,130,246,.16), transparent 65%);
            opacity:.55;
        }

        .card .top{
            display:flex;
            align-items:flex-start;
            gap: 12px;
            position: relative;
            z-index: 1; /* above glow */
        }

        .bubble{
            width:48px; height:48px;
            border-radius: 18px;
            display:grid;
            place-items:center;
            color:#fff;
            flex:0 0 auto;
            box-shadow: 0 10px 25px rgba(0,0,0,0.35);
        }
        .bubble.blue{ background: linear-gradient(135deg, rgba(59,130,246,1), rgba(124,58,237,1)); }
        .bubble.green{ background: linear-gradient(135deg, rgba(34,197,94,1), rgba(16,185,129,1)); }

        .card h3{
            margin:0;
            font-size: 15px;
            letter-spacing:.2px;
            color: rgba(255,255,255,0.96);
        }

        .card p{
            margin: 8px 0 14px;
            color: rgba(229,231,235,0.82);         /* ✅ readable */
            font-size: 13px;
            line-height: 1.45;
            max-width: 520px;
        }

        .btn-primaryx{
            border:none;
            background: linear-gradient(135deg, rgba(124,58,237,1), rgba(59,130,246,1));
        }
        .btn-primaryx:hover{
            background: linear-gradient(135deg, rgba(99,102,241,1), rgba(59,130,246,1));
        }

        .btn-successx{
            border:none;
            background: linear-gradient(135deg, rgba(34,197,94,1), rgba(16,185,129,1));
        }
        .btn-successx:hover{
            background: linear-gradient(135deg, rgba(22,163,74,1), rgba(16,185,129,1));
        }

        /* Responsive */
        @media (max-width: 900px){
            .card{ grid-column: span 12; }
            .topbar{ flex-direction: column; align-items:flex-start; }
            .top-actions{ width:100%; justify-content:flex-end; }
        }
        @media (max-width: 520px){
            .top-actions{ justify-content:space-between; }
        }
    </style>
</head>

<body>
<div class="wrap">
    <section class="head">
        <div class="topbar">
            <div class="titleblock">
                <h1>User Dashboard</h1>
                <p>Welcome back, <strong>{{ auth()->user()->name }}</strong>. Browse listings, manage your bookings, and check notifications.</p>
            </div>

            <div class="top-actions">
                <a href="{{ route('notifications.index') }}" class="btnx icon-btn notification-wrapper" aria-label="Notifications">
                    <span class="bell">🔔</span>
                    @if(auth()->user()->unreadNotifications->count() > 0)
                        <span class="badge-count">{{ auth()->user()->unreadNotifications->count() }}</span>
                    @endif
                </a>

                <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                    @csrf
                    <button class="btnx btn-dangerx" type="submit">🚪 Logout</button>
                </form>
            </div>
        </div>

        <div class="hero">
            <div class="hero-grid">

                <div class="card">
                    <div class="top">
                        <div class="bubble blue">🏘️</div>
                        <div>
                            <h3>Browse All Properties</h3>
                            <p>Explore available listings, view photos and details, and book the property you like.</p>
                            <a href="{{ route('properties.index') }}" class="btnx btn-primaryx">
                                View Properties
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="top">
                        <div class="bubble green">📌</div>
                        <div>
                            <h3>My Bookings</h3>
                            <p>See the properties you’ve booked, check dates, and manage your reservations.</p>
                            <a href="{{ route('my-bookings') }}" class="btnx btn-successx">
                                View My Bookings
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>
</body>
</html>
