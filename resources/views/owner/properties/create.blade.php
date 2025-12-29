<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Add Property</title>

    <style>
        :root{
            --bg: #0b1220;
            --text: #e5e7eb;
            --muted: rgba(229,231,235,0.70);
            --panel: rgba(255,255,255,0.05);
            --panel2: rgba(255,255,255,0.07);
            --border: rgba(255,255,255,0.12);

            --accent: #7c3aed;
            --accent2:#3b82f6;
            --green:#22c55e;
            --red:#ef4444;

            --shadow: 0 22px 70px rgba(0,0,0,0.45);
            --shadow2: 0 12px 34px rgba(0,0,0,0.28);
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
        }
        a{ text-decoration:none; color:inherit; }

        .wrap{
            max-width: 980px;
            margin: 0 auto;
        }

        /* Header row */
        .page-head{
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap: 12px;
            margin-bottom: 14px;
        }
        .titleblock h1{
            margin:0;
            font-size: 20px;
            letter-spacing: .2px;
        }
        .titleblock p{
            margin:6px 0 0;
            color: var(--muted);
            font-size: 13px;
        }

        .head-actions{
            display:flex;
            align-items:center;
            gap: 10px;
            flex-wrap: wrap;
            justify-content:flex-end;
        }

        .btn{
            display:inline-flex;
            align-items:center;
            gap:10px;
            padding: 10px 12px;
            border-radius: 14px;
            border: 1px solid rgba(255,255,255,0.14);
            background: rgba(255,255,255,0.07);
            color: var(--text);
            font-weight: 800;
            font-size: 13px;
            cursor:pointer;
            transition: transform .15s ease, background .15s ease, border-color .15s ease;
            backdrop-filter: blur(10px);
            user-select:none;
        }
        .btn:hover{
            transform: translateY(-1px);
            background: rgba(255,255,255,0.11);
            border-color: rgba(255,255,255,0.22);
        }
        .btn-primary{
            border:none;
            background: linear-gradient(135deg, rgba(124,58,237,1), rgba(59,130,246,1));
        }
        .btn-primary:hover{
            background: linear-gradient(135deg, rgba(99,102,241,1), rgba(59,130,246,1));
        }

        /* Card */
        .card{
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.10);
            border-radius: var(--r-xl);
            box-shadow: var(--shadow);
            overflow:hidden;
        }

        .card-head{
            padding: 16px 18px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            background: rgba(255,255,255,0.04);
            backdrop-filter: blur(12px);
            display:flex;
            align-items:flex-start;
            justify-content:space-between;
            gap: 12px;
        }
        .card-head .left h2{
            margin:0;
            font-size: 16px;
            letter-spacing: .2px;
        }
        .card-head .left p{
            margin:6px 0 0;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.35;
        }

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
        .pill .dot{
            width:10px; height:10px; border-radius:999px;
            background: rgba(148,163,184,0.9);
        }
        .pill.tip .dot{ background: rgba(59,130,246,1); }
        .pill.tip{ border-color: rgba(59,130,246,0.25); background: rgba(59,130,246,0.10); }

        .card-body{
            padding: 18px;
        }

        /* Success message */
        .flash{
            margin: 0 0 14px;
            padding: 12px 14px;
            border-radius: 14px;
            border: 1px solid rgba(34,197,94,0.25);
            background: rgba(34,197,94,0.10);
            box-shadow: var(--shadow2);
            color: rgba(229,231,235,0.95);
            font-weight: 700;
        }

        /* Form grid */
        form{
            display:grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 12px;
        }

        .field{
            grid-column: span 12;
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.09);
            border-radius: var(--r-lg);
            padding: 12px;
        }
        .field.half{ grid-column: span 6; }
        .field label{
            display:block;
            font-size: 12px;
            letter-spacing: .35px;
            text-transform: uppercase;
            color: rgba(229,231,235,0.70);
            font-weight: 900;
            margin-bottom: 8px;
        }

        input[type="text"],
        input[type="number"],
        textarea,
        select{
            width:100%;
            padding: 11px 12px;
            border-radius: 14px;
            border: 1px solid rgba(255,255,255,0.12);
            background: rgba(12,18,34,0.55);
            color: rgba(229,231,235,0.92);
            outline: none;
            font-size: 14px;
            transition: border-color .15s ease, background .15s ease;
        }
        input::placeholder,
        textarea::placeholder{
            color: rgba(229,231,235,0.45);
        }
        input:focus,
        textarea:focus,
        select:focus{
            border-color: rgba(124,58,237,0.55);
            background: rgba(12,18,34,0.72);
        }

        textarea{ min-height: 110px; resize: vertical; }

        .hint{
            margin-top: 8px;
            font-size: 12px;
            color: rgba(229,231,235,0.62);
        }

        .error{
            margin-top: 8px;
            font-size: 13px;
            color: rgba(239,68,68,0.95);
            font-weight: 800;
        }

        /* File input - nicer */
        .filebox{
            display:flex;
            align-items:center;
            gap: 10px;
            flex-wrap: wrap;
        }
        input[type="file"]{
            width:100%;
            padding: 10px 12px;
            border-radius: 14px;
            border: 1px dashed rgba(255,255,255,0.18);
            background: rgba(12,18,34,0.45);
            color: rgba(229,231,235,0.78);
        }

        /* Preview images */
        .preview{
            margin-top: 10px;
            display:flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        .thumb{
            width: 92px;
            height: 72px;
            border-radius: 14px;
            border: 1px solid rgba(255,255,255,0.12);
            object-fit: cover;
            box-shadow: 0 10px 24px rgba(0,0,0,0.25);
        }

        /* Footer actions */
        .form-actions{
            grid-column: span 12;
            display:flex;
            justify-content:flex-end;
            gap: 10px;
            margin-top: 4px;
        }

        .btn-ghost{
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.14);
        }

        .btn-save{
            border:none;
            background: linear-gradient(135deg, rgba(34,197,94,1), rgba(16,185,129,1));
        }
        .btn-save:hover{
            background: linear-gradient(135deg, rgba(22,163,74,1), rgba(16,185,129,1));
        }

        @media (max-width: 820px){
            .field.half{ grid-column: span 12; }
            .page-head{ flex-direction: column; align-items:flex-start; }
            .head-actions{ width:100%; justify-content:flex-start; }
        }
    </style>
</head>
<body>
<div class="wrap">

    <div class="page-head">
        <div class="titleblock">
            <h1>Add Property</h1>
            <p>Create a new listing with photos, pricing, and availability.</p>
        </div>

        <div class="head-actions">
            <a class="btn" href="/owner/dashboard">
                ← Back to Dashboard
            </a>
            <a class="btn btn-primary" href="/owner/properties">
                📄 My Properties
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-head">
            <div class="left">
                <h2>Add New Property</h2>
                <p>Fill in the details below. Upload multiple images to make your listing attractive.</p>
            </div>
            <div class="pill tip"><span class="dot"></span> Tip: Add clear photos</div>
        </div>

        <div class="card-body">

            @if(session('success'))
                <div class="flash">{{ session('success') }}</div>
            @endif

            <form action="/owner/properties" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="field">
                    <label>Title</label>
                    <input type="text" name="title" value="{{ old('title') }}" required placeholder="e.g., Modern 2-bedroom apartment">
                    @error('title')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label>Description</label>
                    <textarea name="description" placeholder="Describe rooms, facilities, nearby locations...">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field half">
                    <label>Rent Price</label>
                    <input type="number" name="rent_price" min="1" value="{{ old('rent_price') }}" required placeholder="Monthly rent (BDT)">
                    @error('rent_price')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field half">
                    <label>Availability</label>
                    <select name="availability" required>
                        <option value="1" {{ old('availability') === '1' ? 'selected' : '' }}>Available</option>
                        <option value="0" {{ old('availability') === '0' ? 'selected' : '' }}>Not Available</option>
                    </select>
                    @error('availability')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label>Address</label>
                    <input type="text" name="address" value="{{ old('address') }}" required placeholder="e.g., Chittagong, Bangladesh">
                    @error('address')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label>Owner Info</label>
                    <textarea name="owner_info" required placeholder="Owner contact details / notes">{{ old('owner_info') }}</textarea>
                    @error('owner_info')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label>Property Images</label>
                    <div class="filebox">
                        <input id="imagesInput" type="file" name="images[]" multiple accept="image/*">
                    </div>
                    <div class="hint">Max file size 100 MB. You can select multiple images.</div>

                    <!-- Preview thumbnails (client-side only) -->
                    <div class="preview" id="preview"></div>

                    @error('images')
                        <div class="error">{{ $message }}</div>
                    @enderror
                    @error('images.*')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-actions">
                    <a class="btn btn-ghost" href="/owner/dashboard">Cancel</a>
                    <button class="btn btn-save" type="submit">✅ Save Property</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Simple image preview thumbnails
    const input = document.getElementById('imagesInput');
    const preview = document.getElementById('preview');

    if (input && preview) {
        input.addEventListener('change', () => {
            preview.innerHTML = '';
            const files = Array.from(input.files || []);
            files.slice(0, 12).forEach(file => { // limit previews
                const url = URL.createObjectURL(file);
                const img = document.createElement('img');
                img.src = url;
                img.className = 'thumb';
                img.alt = 'Preview';
                preview.appendChild(img);
            });
        });
    }
</script>

</body>
</html>
