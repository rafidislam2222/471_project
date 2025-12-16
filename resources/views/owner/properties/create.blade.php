<!DOCTYPE html>
<html>
<head>
    <title>Add Property</title>
    <!-- Added simple responsive meta and styles for better appearance -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        :root{
            --accent:#2b6cb0;
            --muted:#6b7280;
            --danger:#e53e3e;
            --success:#2f855a;
            --bg:#f7fafc;
            --card:#ffffff;
        }
        body{
            margin:0;
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
            background:var(--bg);
            color:#111827;
            padding:24px;
        }
        .container{
            max-width:760px;
            margin:20px auto;
            background:var(--card);
            border-radius:8px;
            box-shadow:0 6px 18px rgba(15,23,42,0.08);
            padding:28px;
        }
        h1{
            margin:0 0 16px 0;
            font-size:20px;
            color:var(--accent);
            text-align:center;
        }
        form {
            display:flex;
            flex-direction:column;
            gap:12px;
        }
        label{
            font-size:13px;
            color:var(--muted);
            display:block;
            margin-bottom:6px;
        }
        input[type="text"],
        input[type="number"],
        select,
        textarea,
        input[type="file"] {
            width:100%;
            padding:10px 12px;
            border:1px solid #e5e7eb;
            border-radius:6px;
            background:#fff;
            font-size:14px;
            box-sizing:border-box;
        }
        textarea { min-height:100px; resize:vertical; }
        .row { display:flex; gap:12px; }
        .col { flex:1; }
        .muted { font-size:13px; color:var(--muted); margin-bottom:6px; }
        .error { color:var(--danger); font-size:13px; margin-top:4px; }
        .success { color:var(--success); font-size:14px; margin-bottom:8px; text-align:center; }
        button {
            background:var(--accent);
            color:#fff;
            padding:10px 14px;
            border-radius:6px;
            border:0;
            cursor:pointer;
            font-weight:600;
            margin-top:8px;
        }
        button:hover { filter:brightness(0.95); }
        @media (max-width:520px){
            .container{ padding:18px; }
            h1{ font-size:18px; }
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Add New Property</h1>

    {{-- Success message --}}
    @if(session('success'))
        <p class="success">{{ session('success') }}</p>
    @endif

    <form action="/owner/properties" method="POST" enctype="multipart/form-data">

        @csrf

        <div>
            <label>Title:</label>
            <input type="text" name="title" value="{{ old('title') }}" required placeholder="Enter property title">
            @error('title')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label>Description:</label>
            <textarea name="description" placeholder="Brief description of the property">{{ old('description') }}</textarea>
            @error('description')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="row">
            <div class="col">
                <label>Rent Price:</label>
                <input type="number" name="rent_price" min="1" value="{{ old('rent_price') }}" required placeholder="Monthly rent">
                @error('rent_price')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="col">
                <label>Availability:</label>
                <select name="availability" required>
                    <option value="1" {{ old('availability') === '1' ? 'selected' : '' }}>Available</option>
                    <option value="0" {{ old('availability') === '0' ? 'selected' : '' }}>Not Available</option>
                </select>
                @error('availability')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label>Address:</label>
            <input type="text" name="address" value="{{ old('address') }}" required placeholder="Property address">
            @error('address')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label>Owner Info:</label>
            <textarea name="owner_info" required placeholder="Owner contact details / notes">{{ old('owner_info') }}</textarea>
            @error('owner_info')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <!-- NEW: MULTIPLE IMAGES UPLOAD -->
        <div>
            <label>Property Images:</label>
            <input type="file" name="images[]" multiple accept="image/*">
            <p class="muted">Max file size 100 mb.</p>
            @error('images')
                <p class="error">{{ $message }}</p>
            @enderror
            @error('images.*')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit">Save Property</button>

    </form>
</div>

</body>
</html>