<!DOCTYPE html>
<html>
<head>
    <title>All Properties</title>
</head>
<body>

<h1>Available Properties</h1>

<a href="/user/dashboard"
   style="display:inline-block; margin-bottom:15px; padding:8px 14px; 
          background:#444; color:white; text-decoration:none; border-radius:5px;">
    ⬅ Back to Dashboard
</a>

@if(session('success'))
    <p style="color: green">{{ session('success') }}</p>
@endif

@if(session('error'))
    <p style="color: red">{{ session('error') }}</p>
@endif

<h2>Search Properties</h2>

<form method="GET" action="/properties">
    <label>Location:</label>
    <input type="text" name="address" value="{{ request('address') }}">

    <label>Min Price:</label>
    <input type="number" name="min_price" value="{{ request('min_price') }}">

    <label>Max Price:</label>
    <input type="number" name="max_price" value="{{ request('max_price') }}">

    <button type="submit">Search</button>
     <!-- RESET BUTTON -->
    <a href="/properties"
       style="padding:6px 10px; background:#ccc; color:black; text-decoration:none; margin-left:10px;">
        Reset
    </a>
</form>

<hr>

<table border="1" cellpadding="10">
    <tr>
        <th>Images</th>
        <th>Title</th>
        <th>Rent</th>
        <th>Address</th>
        <th>Status</th>
        <th>Details</th>
    </tr>

    @foreach($properties as $property)
    <tr>

        {{-- SHOW IMAGES --}}
        <td>
            @php
                // FIX: ensure images is always an array
                $images = is_array($property->images)
                        ? $property->images
                        : (json_decode($property->images, true) ?? []);
            @endphp

            @if(!empty($images))
                @foreach($images as $img)
                    <img src="{{ asset('storage/property_images/'.$img) }}"
                        width="250" height="200"
                        style="object-fit:cover; margin-right:5px;">
                @endforeach
            @else
                <i>No Images</i>
            @endif
        </td>

        <td>{{ $property->title }}</td>
        <td>{{ $property->rent_price }}</td>
        <td>{{ $property->address }}</td>

        <td>
            @if($property->availability == 1)
                <span style="color: green">Available</span>
            @else
                <span style="color: red">Booked</span>
            @endif
        </td>

        <td>
            <a href="/properties/{{ $property->id }}">View</a>
        </td>
    </tr>
    @endforeach
</table>

</body>
</html>
