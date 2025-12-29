<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>My Properties</title>

    <style>
        :root{
            --bg: #0b1220;
            --panel: rgba(255,255,255,0.04);
            --panel2: rgba(255,255,255,0.06);
            --border: rgba(255,255,255,0.12);
            --text: #e5e7eb;
            --muted: rgba(229,231,235,0.72);

            --accent: #7c3aed;
            --blue: #3b82f6;
            --green: #22c55e;
            --red: #ef4444;

            --shadow: 0 20px 60px rgba(0,0,0,0.35);
            --shadow2: 0 12px 30px rgba(0,0,0,0.25);
            --radius-xl: 22px;
            --radius-lg: 16px;
        }

        *{ box-sizing:border-box; }
        body{
            margin:0;
            font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial;
            color: var(--text);
            background:
                radial-gradient(900px 450px at 12% 8%, rgba(124,58,237,.35), transparent 60%),
                radial-gradient(800px 420px at 96% 12%, rgba(34,197,94,.22), transparent 55%),
                radial-gradient(1100px 550px at 50% 120%, rgba(59,130,246,.16), transparent 60%),
                var(--bg);
            min-height: 100vh;
        }
        a{ text-decoration:none; color:inherit; }

        .wrap{
            max-width: 1200px;
            margin: 26px auto;
            padding: 0 18px 26px;
        }

        /* Top bar */
        .topbar{
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap: 12px;
            margin-bottom: 14px;
        }
        .titleblock h1{
            margin:0;
            font-size: 22px;
            letter-spacing: .2px;
        }
        .titleblock p{
            margin:6px 0 0;
            color: var(--muted);
            font-size: 13px;
        }

        .btn{
            display:inline-flex;
            align-items:center;
            gap:10px;
            padding: 11px 14px;
            border-radius: 14px;
            border: 1px solid rgba(255,255,255,0.14);
            background: rgba(255,255,255,0.08);
            color: var(--text);
            font-weight: 800;
            font-size: 13px;
            cursor:pointer;
            transition: transform .15s ease, background .15s ease, border-color .15s ease;
            backdrop-filter: blur(10px);
        }
        .btn:hover{
            transform: translateY(-1px);
            background: rgba(255,255,255,0.12);
            border-color: rgba(255,255,255,0.22);
        }
        .btn-primary{
            background: linear-gradient(135deg, rgba(34,197,94,1), rgba(16,185,129,1));
            border: none;
        }
        .btn-primary:hover{
            background: linear-gradient(135deg, rgba(22,163,74,1), rgba(16,185,129,1));
        }

        /* Flash message */
        .flash{
            margin: 10px 0 14px;
            padding: 12px 14px;
            border-radius: 14px;
            border: 1px solid rgba(34,197,94,0.25);
            background: rgba(34,197,94,0.10);
            color: rgba(229,231,235,0.95);
            box-shadow: var(--shadow2);
        }

        /* Table container */
        .card{
            background: var(--panel);
            border: 1px solid rgba(255,255,255,0.10);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow);
            overflow:hidden;
        }

        /* Make table horizontally scrollable on small screens */
        .table-wrap{
            overflow:auto;
        }

        table{
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            min-width: 980px; /* keeps columns nice; scroll on small screens */
        }

        thead th{
            position: sticky;
            top: 0;
            z-index: 1;
            background: rgba(255,255,255,0.07);
            backdrop-filter: blur(10px);
            color: rgba(229,231,235,0.92);
            font-size: 12px;
            letter-spacing: .4px;
            text-transform: uppercase;
            padding: 14px 14px;
            border-bottom: 1px solid rgba(255,255,255,0.10);
            text-align: left;
            white-space: nowrap;
        }

        tbody td{
            padding: 14px 14px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            vertical-align: top;
            color: rgba(229,231,235,0.90);
            font-size: 14px;
        }

        tbody tr:hover td{
            background: rgba(255,255,255,0.04);
        }

        /* Title cell */
        .prop-title{
            font-weight: 800;
            margin:0 0 6px;
        }
        .prop-sub{
            margin:0;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.35;
        }

        /* Images grid */
        .img-grid{
            display:flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        img.property-img{
            width: 400px;
            height: 280px;
            object-fit: cover;
            border-radius: 14px;
            border: 1px solid rgba(255,255,255,0.12);
            box-shadow: 0 10px 24px rgba(0,0,0,0.25);
        }
        .no-img{
            color: var(--muted);
            font-style: italic;
            font-size: 13px;
        }

        /* Rent */
        .rent{
            font-weight: 900;
            font-size: 14px;
            white-space: nowrap;
        }
        .rent small{
            display:block;
            margin-top: 4px;
            color: var(--muted);
            font-weight: 700;
            font-size: 12px;
        }

        /* Availability pill */
        .pill{
            display:inline-flex;
            align-items:center;
            gap:8px;
            padding: 8px 10px;
            border-radius: 999px;
            font-weight: 900;
            font-size: 12px;
            border: 1px solid rgba(255,255,255,0.14);
            background: rgba(255,255,255,0.06);
            white-space: nowrap;
        }
        .dot{
            width:10px; height:10px; border-radius: 999px;
            background: rgba(148,163,184,0.9);
        }
        .pill.available{
            border-color: rgba(34,197,94,0.25);
            background: rgba(34,197,94,0.10);
        }
        .pill.available .dot{ background: rgba(34,197,94,1); }

        .pill.unavailable{
            border-color: rgba(239,68,68,0.25);
            background: rgba(239,68,68,0.10);
        }
        .pill.unavailable .dot{ background: rgba(239,68,68,1); }

        /* Actions */
        .actions{
            display:flex;
            gap:10px;
            align-items:center;
            flex-wrap: wrap;
            white-space: nowrap;
        }
        .link{
            display:inline-flex;
            align-items:center;
            gap:8px;
            padding: 9px 10px;
            border-radius: 12px;
            border: 1px solid rgba(255,255,255,0.14);
            background: rgba(255,255,255,0.06);
            font-weight: 900;
            font-size: 13px;
            transition: transform .15s ease, background .15s ease, border-color .15s ease;
        }
        .link:hover{
            transform: translateY(-1px);
            background: rgba(255,255,255,0.10);
            border-color: rgba(255,255,255,0.22);
        }
        .link.edit{
            border-color: rgba(59,130,246,0.25);
            background: rgba(59,130,246,0.12);
        }
        .link.delete{
            border-color: rgba(239,68,68,0.25);
            background: rgba(239,68,68,0.12);
        }

        /* Small screens: stack header */
        @media (max-width: 700px){
            .topbar{ flex-direction: column; align-items:flex-start; }
            .btn{ width: 100%; justify-content:center; }
        }
    </style>
</head>

<body>
<div class="wrap">

    <div class="topbar">
        <!-- Back button: goes to previous page, fallback to /owner/dashboard if history empty -->
        <button class="btn" onclick="(history.length>1)?history.back():window.location.href='/owner/dashboard';" title="Go back">
            ← Back
        </button>

        <div class="titleblock">
            <h1>My Properties</h1>
            <p>Manage your listings, photos, pricing, and availability.</p>
        </div>

        <a class="btn btn-primary" href="/owner/properties/create">
            <span style="font-size:16px;">➕</span>
            Add New Property
        </a>
    </div>

    @if(session('success'))
        <div class="flash">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:70px;">ID</th>
                        <th style="width:240px;">Title</th>
                        <th style="width:420px;">Images</th>
                        <th style="width:140px;">Rent</th>
                        <th style="width:240px;">Address</th>
                        <th style="width:160px;">Availability</th>
                        <th style="width:180px;">Actions</th>
                    </tr>
                </thead>

                <tbody>
                @foreach($properties as $property)
                    <tr>
                        <td style="font-weight:900;">#{{ $property->id }}</td>

                        <td>
                            <div class="prop-title">{{ $property->title }}</div>
                            <p class="prop-sub">Listing details and management</p>
                        </td>

                        <td>
                            @php
                                $images = is_string($property->images)
                                    ? json_decode($property->images, true)
                                    : (is_array($property->images) ? $property->images : []);
                            @endphp

                            @if(!empty($images))
                                <div class="img-grid">
                                    @foreach($images as $img)
                                        <img
                                            src="{{ asset('storage/property_images/'.$img) }}"
                                            class="property-img"
                                            alt="Property image"
                                        >
                                    @endforeach
                                </div>
                            @else
                                <span class="no-img">No Images</span>
                            @endif
                        </td>

                        <td class="rent">
                            {{ number_format((float)$property->rent_price, 2) }}
                            <small>BDT / month</small>
                        </td>

                        <td>{{ $property->address }}</td>

                        <td>
                            @if($property->availability)
                                <span class="pill available"><span class="dot"></span> Available</span>
                            @else
                                <span class="pill unavailable"><span class="dot"></span> Not Available</span>
                            @endif
                        </td>

                        <td>
                            <div class="actions">
                                <a class="link edit" href="/owner/properties/{{ $property->id }}/edit">
                                    ✏ Edit
                                </a>

                                <a class="link delete"
                                   href="/owner/properties/{{ $property->id }}/delete"
                                   onclick="return confirm('Delete this property?')">
                                    🗑 Delete
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
</body>
</html>
