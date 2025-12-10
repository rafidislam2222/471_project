<!DOCTYPE html>
<html>
<head>
    <title>My Properties</title>

    <style>
        img.property-img {
            width: 120px;
            height: 90px;
            object-fit: cover;
            margin: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        td {
            vertical-align: top;
        }
    </style>
</head>
<body>

<h1>My Properties</h1>

<a href="/owner/properties/create">➕ Add New Property</a>

<br><br>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

<table border="1" cellpadding="10" width="100%">
    <tr>
        <th width="5%">ID</th>
        <th width="20%">Title</th>
        <th width="35%">Images</th>
        <th width="10%">Rent</th>
        <th width="15%">Address</th>
        <th width="10%">Availability</th>
        <th width="10%">Actions</th>
    </tr>

    @foreach($properties as $property)
    <tr>
        <td>{{ $property->id }}</td>
        <td>{{ $property->title }}</td>

        {{-- SHOW IMAGES --}}
        <td>
            @php
                // Decode JSON safely
                $images = is_string($property->images)
                    ? json_decode($property->images, true)
                    : (is_array($property->images) ? $property->images : []);
            @endphp

            @if(!empty($images))
                @foreach($images as $img)
                    <img src="{{ asset('storage/property_images/'.$img) }}" class="property-img">
                @endforeach
            @else
                <i>No Images</i>
            @endif
        </td>

        <td>{{ $property->rent_price }}</td>
        <td>{{ $property->address }}</td>
        <td>{{ $property->availability ? 'Available' : 'Not Available' }}</td>

        <td>
            <a href="/owner/properties/{{ $property->id }}/edit">✏ Edit</a> |
            <a href="/owner/properties/{{ $property->id }}/delete"
               onclick="return confirm('Delete this property?')">🗑 Delete</a>
        </td>
    </tr>
    @endforeach
</table>

</body>
</html>
