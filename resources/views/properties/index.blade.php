<!DOCTYPE html>
<html>
<head>
    <title>All Properties</title>
</head>
<body>

<h1>Available Properties</h1>

@if(session('success'))
    <p style="color: green">{{ session('success') }}</p>
@endif

@if(session('error'))
    <p style="color: red">{{ session('error') }}</p>
@endif

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
                        width="80" height="80"
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
