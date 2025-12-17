<!DOCTYPE html>
<html>
<head>
    <title>My Booked Properties</title>
    <style>
        .image-grid {
            display: flex;
            gap: 10px;
        }
        .image-grid img {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>

<h1>My Booked Properties</h1>

<a href="/user/dashboard">⬅ Back to Dashboard</a>

<br><br>

@if($bookings->isEmpty())
    <p>You have not booked any properties yet.</p>
@else
    <table border="1" cellpadding="10">
        <tr>
            <th>Images</th>
            <th>Title</th>
            <th>Rent</th>
            <th>Address</th>
            <th>Start Date</th>
            <th>Status</th>
        </tr>

        @foreach($bookings as $booking)
        <tr>

            {{-- PROPERTY IMAGES --}}
            <td>
                @php
                    $images = is_string($booking->property->images) 
                        ? json_decode($booking->property->images, true) 
                        : $booking->property->images;
                @endphp
                
                @if(is_array($images) && count($images) > 0)
                    <div class="image-grid">
                        @foreach($images as $img)
                            <img src="{{ asset('storage/property_images/' . trim($img)) }}" alt="Property image">
                        @endforeach
                    </div>
                @else
                    <i>No Images</i>
                @endif
            </td>

            <td>{{ $booking->property->title }}</td>
            <td>{{ $booking->property->rent_price }}</td>
            <td>{{ $booking->property->address }}</td>
            <td>{{ $booking->start_date }}</td>
            <td style="color:red;">Booked</td>

        </tr>
        @endforeach
    </table>
@endif

</body>
</html>
