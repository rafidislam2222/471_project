<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $property->title }} - Details</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root{
            --bg:#f6f7fb;
            --card:#ffffff;
            --text:#0f172a;
            --muted:#64748b;
            --border:#e5e7eb;

            --brand1:#6d5bd0;
            --brand2:#7c3aed;

            --green:#22c55e;
            --red:#ef4444;

            --shadow: 0 14px 40px rgba(15,23,42,.10);
            --radius: 16px;
        }

        *{ box-sizing:border-box; }
        body{
            margin:0;
            font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial;
            background: var(--bg);
            color: var(--text);
        }
        a{ text-decoration:none; color:inherit; }

        /* Top nav */
        .nav{
            position: sticky;
            top: 0;
            z-index: 50;
            height: 68px;
            background: linear-gradient(90deg, var(--brand1), var(--brand2));
            display:flex;
            align-items:center;
            justify-content:space-between;
            padding: 0 18px;
            box-shadow: 0 10px 26px rgba(15,23,42,.18);
        }
        .brand{
            display:flex;
            align-items:center;
            gap:10px;
            color:#fff;
            font-weight: 900;
            letter-spacing:.2px;
        }
        .brand i{ font-size: 20px; }

        .nav-actions{
            display:flex;
            align-items:center;
            gap:10px;
            color:#fff;
        }

        .btn{
            border:0;
            border-radius: 12px;
            padding: 10px 14px;
            font-weight: 800;
            cursor:pointer;
            display:inline-flex;
            align-items:center;
            gap:8px;
        }
        .btn-light{
            background: rgba(255,255,255,.18);
            color:#fff;
            border: 1px solid rgba(255,255,255,.25);
        }
        .btn-light:hover{ background: rgba(255,255,255,.26); }

        /* Layout */
        .wrap{
            max-width: 1180px;
            margin: 22px auto;
            padding: 0 18px 40px;
        }

        .page-head{
            display:flex;
            align-items:flex-start;
            justify-content:space-between;
            gap: 14px;
            margin-bottom: 14px;
        }
        .page-head h1{
            margin:0;
            font-size: 30px;
            letter-spacing:.2px;
        }
        .page-head p{
            margin: 6px 0 0;
            color: var(--muted);
        }

        .grid{
            display:grid;
            grid-template-columns: 1.35fr .9fr;
            gap: 16px;
            margin-top: 14px;
        }

        .card{
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 16px;
        }

        /* Alerts */
        .alert{
            margin-top: 10px;
            padding: 10px 12px;
            border-radius: 12px;
            font-weight: 800;
            font-size: 14px;
        }
        .alert-success{ background: rgba(34,197,94,.12); color:#15803d; }
        .alert-error{ background: rgba(239,68,68,.12); color:#b91c1c; }

        /* Gallery */
        .gallery{
            display:grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }
        .img-tile{
            border-radius: 14px;
            overflow:hidden;
            border: 1px solid var(--border);
            background: #eef2ff;
            cursor:pointer;
            position:relative;
        }
        .img-tile img{
            width:100%;
            height: 220px;
            object-fit: cover;
            display:block;
            transition: transform .2s ease;
        }
        .img-tile:hover img{ transform: scale(1.03); }
        .no-images{
            padding: 22px;
            color: var(--muted);
            border: 1px dashed var(--border);
            border-radius: 14px;
            text-align:center;
            background: #fafafa;
        }

        /* Property meta */
        .meta{
            display:grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
            margin-top: 14px;
        }
        .meta .box{
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 12px;
            background: #fbfbff;
        }
        .label{
            font-size: 12px;
            color: var(--muted);
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .3px;
        }
        .value{ margin-top: 6px; font-weight: 900; }

        .status{
            display:inline-flex;
            align-items:center;
            gap:8px;
            padding: 8px 10px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 900;
        }
        .status.available{ background: rgba(34,197,94,.14); color: #15803d; }
        .status.unavailable{ background: rgba(239,68,68,.14); color: #b91c1c; }
        .dot{
            width:10px; height:10px; border-radius: 999px;
            background: currentColor;
        }

        /* Weather */
        .weather{
            display:grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin-top: 10px;
        }

        /* Booking */
        .book-row{
            display:flex;
            gap:10px;
            align-items:center;
            margin-top: 12px;
            flex-wrap: wrap;
        }
        input[type="date"]{
            padding: 10px 12px;
            border-radius: 12px;
            border: 1px solid var(--border);
            background: #fff;
            min-width: 220px;
            font-weight: 700;
        }
        .btn-primary{
            background: linear-gradient(90deg, var(--brand1), var(--brand2));
            color:#fff;
        }
        .btn-primary:hover{ filter: brightness(.98); }

        /* Modal */
        .modal{
            display:none;
            position: fixed;
            inset: 0;
            background: rgba(2,6,23,.65);
            z-index: 999;
            padding: 24px;
            align-items:center;
            justify-content:center;
        }
        .modal-inner{
            max-width: 980px;
            width: 100%;
            background: #0b1220;
            border-radius: 16px;
            overflow:hidden;
            border: 1px solid rgba(255,255,255,.12);
        }
        .modal-top{
            padding: 10px 12px;
            display:flex;
            justify-content:space-between;
            align-items:center;
            color:#fff;
            background: rgba(255,255,255,.06);
        }
        .modal img{
            width: 100%;
            height: auto;
            display:block;
        }
        .close{
            cursor:pointer;
            padding: 8px 10px;
            border-radius: 10px;
            background: rgba(255,255,255,.10);
        }
        .close:hover{ background: rgba(255,255,255,.16); }

        @media (max-width: 980px){
            .grid{ grid-template-columns: 1fr; }
            .gallery{ grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 520px){
            .gallery{ grid-template-columns: 1fr; }
            .page-head h1{ font-size: 24px; }
            input[type="date"]{ min-width: 100%; }
            .btn{ width: 100%; justify-content:center; }
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <div class="nav">
        <div class="brand">
            <i class="fa-solid fa-house-chimney"></i>
            <span>RentalHub</span>
        </div>

        <div class="nav-actions">
            <a class="btn btn-light" href="/properties">
                <i class="fa-solid fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="wrap">

        <div class="page-head">
            <div>
                <h1>{{ $property->title }}</h1>
                <p>Property details, pricing, weather, and booking.</p>
            </div>
        </div>

        <div class="grid">

            <!-- LEFT: Photos + Details -->
            <div class="card">
                <div style="font-weight:900; margin-bottom:10px;">
                    <i class="fa-regular fa-images"></i> Photos
                </div>

                @php
                    // Ensure images is always an array (safe)
                    $images = is_string($property->images)
                        ? json_decode($property->images, true)
                        : (is_array($property->images) ? $property->images : []);
                    $images = $images ?? [];
                @endphp

                @if(count($images) > 0)
                    <div class="gallery">
                        @foreach($images as $img)
                            <div class="img-tile" onclick="openModal('{{ asset('storage/property_images/'.$img) }}')">
                                <img src="{{ asset('storage/property_images/'.$img) }}" alt="Property image">
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="no-images">
                        <i class="fa-regular fa-image" style="font-size:20px;"></i>
                        <div style="margin-top:8px; font-weight:900;">No images uploaded</div>
                        <div style="margin-top:4px;">This listing does not have photos yet.</div>
                    </div>
                @endif

                <div class="meta">
                    <div class="box">
                        <div class="label">Rent Price</div>
                        <div class="value">{{ number_format((float)$property->rent_price, 2) }} BDT / month</div>
                    </div>

                    <div class="box">
                        <div class="label">Status</div>
                        <div class="value">
                            @if($property->availability == 1)
                                <span class="status available"><span class="dot"></span> Available</span>
                            @else
                                <span class="status unavailable"><span class="dot"></span> Booked</span>
                            @endif
                        </div>
                    </div>

                    <div class="box" style="grid-column: 1 / -1;">
                        <div class="label">Address</div>
                        <div class="value">{{ $property->address }}</div>
                    </div>
                </div>
            </div>

            <!-- RIGHT: Weather + Booking -->
            <div style="display:flex; flex-direction:column; gap:16px;">

                <div class="card">
                    <div style="display:flex; align-items:center; justify-content:space-between;">
                        <div style="font-weight:900;">
                            <i class="fa-solid fa-cloud-sun"></i> Weather
                        </div>
                        <div style="color:var(--muted); font-weight:800; font-size:12px;">
                            Based on address
                        </div>
                    </div>

                    @if($weather)
                        <div class="weather">
                            <div class="box">
                                <div class="label">Temperature</div>
                                <div class="value">{{ $weather['temperature'] ?? 'N/A' }}°C</div>
                            </div>
                            <div class="box">
                                <div class="label">Humidity</div>
                                <div class="value">{{ $weather['humidity'] ?? 'N/A' }}%</div>
                            </div>
                            <div class="box">
                                <div class="label">Condition</div>
                                <div class="value" style="text-transform:capitalize;">
                                    {{ $weather['condition'] ?? 'N/A' }}
                                </div>
                            </div>
                        </div>
                    @else
                        <div style="margin-top:10px; color:var(--muted);">
                            Weather data unavailable.
                        </div>
                    @endif
                </div>

                <div class="card">
                    <div style="font-weight:900;">
                        <i class="fa-solid fa-calendar-check"></i> Booking
                    </div>

                    @if(session('error'))
                        <div class="alert alert-error">{{ session('error') }}</div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if($property->availability == 1)
                        <form action="/properties/{{ $property->id }}/book" method="POST" style="margin-top:12px;">
                            @csrf

                            <div class="book-row">
                                <div>
                                    <div class="label" style="margin-bottom:6px;">Start Date</div>
                                    <input type="date" name="start_date" required>
                                    @error('start_date')
                                        <div style="color:#b91c1c; font-size:13px; margin-top:6px;">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button class="btn btn-primary" type="submit">
                                    <i class="fa-solid fa-bolt"></i> Book Now
                                </button>
                            </div>

                            <div style="margin-top:10px; color:var(--muted); font-size:13px;">
                                You’ll receive a confirmation after booking.
                            </div>
                        </form>
                    @else
                        <div class="alert alert-error" style="margin-top:12px;">
                            This property is already booked.
                        </div>
                    @endif
                </div>

            </div>
        </div>

    </div>

    <!-- Image Modal -->
    <div class="modal" id="imgModal" onclick="closeModal(event)">
        <div class="modal-inner">
            <div class="modal-top">
                <div style="font-weight:900;">Preview</div>
                <div class="close" onclick="forceCloseModal()">
                    <i class="fa-solid fa-xmark"></i>
                </div>
            </div>
            <img id="modalImg" src="" alt="Preview">
        </div>
    </div>

    <script>
        function openModal(src){
            const m = document.getElementById("imgModal");
            const img = document.getElementById("modalImg");
            img.src = src;
            m.style.display = "flex";
        }
        function closeModal(e){
            if (e.target.id === "imgModal") {
                forceCloseModal();
            }
        }
        function forceCloseModal(){
            document.getElementById("imgModal").style.display = "none";
            document.getElementById("modalImg").src = "";
        }
        window.addEventListener("keydown", function(e){
            if (e.key === "Escape") forceCloseModal();
        });
    </script>

</body>
</html>
