<!DOCTYPE html>
<html>
<head>
    <title>{{ $property->title }} - Details</title>
</head>
<body>

<h1>{{ $property->title }}</h1>

{{-- Property IMAGES --}}
<div>
    <h3>Images:</h3>

    @php
        // FIX: Ensure images is always an array
        $images = is_array($property->images) ? $property->images : json_decode($property->images, true);
        $images = $images ?? []; // fallback
    @endphp

    @if(count($images) > 0)
        @foreach($images as $img)
            <img src="{{ asset('storage/property_images/' . $img) }}"
                 width="200" height="200"
                 style="object-fit:cover; margin-right:10px;">
        @endforeach
    @else
        <p>No Images</p>
    @endif
</div>

<hr>

<p><strong>Rent Price:</strong> {{ $property->rent_price }}</p>
<p><strong>Address:</strong> {{ $property->address }}</p>

<p><strong>Status:</strong>
    @if($property->availability == 1)
        <span style="color:green">Available</span>
    @else
        <span style="color:red">Booked</span>
    @endif
</p>

<hr>

{{-- WEATHER SECTION --}}
<h2>Weather Information</h2>

@if($weather)
    <p><strong>Temperature:</strong> {{ $weather['temperature'] }}°C</p>
    <p><strong>Humidity:</strong> {{ $weather['humidity'] }}%</p>
    <p><strong>Condition:</strong> {{ $weather['condition'] }}</p>
@else
    <p>Weather data unavailable.</p>
@endif

<hr>

{{-- BOOKING FORM (only if available) --}}
@if($property->availability == 1)
    <h2>Book This Property</h2>

    @if(session('error'))
        <p style="color:red">{{ session('error') }}</p>
    @endif

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    <form action="/properties/{{ $property->id }}/book" method="POST">
        @csrf

        <label>Start Date:</label>
        <input type="date" name="start_date" required>

        <button type="submit">Book Now</button>
    </form>

@else
    <h3 style="color:red">This property is already booked.</h3>
@endif

<hr>

<a href="/properties">⬅ Back to All Properties</a>

</body>
</html>
