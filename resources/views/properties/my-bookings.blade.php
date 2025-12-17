<!DOCTYPE html>
<html>
<head><title>My Bookings</title></head>
<body>
    <h1>My Booked Properties</h1>
    @if(session('success')) <p style="color:green">{{ session('success') }}</p> @endif

    <table border="1" cellpadding="10">
        <tr>
            <th>Property</th>
            <th>Location</th>
            <th>Booked Date</th>
            <th>Action</th>
        </tr>
        @foreach($bookings as $booking)
        <tr>
            <td>{{ $booking->property->title }}</td>
            <td>{{ $booking->property->address }}</td>
            <td>{{ $booking->start_date }}</td>
            <td>
                <form action="{{ route('bookings.cancel', $booking->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="color:red">Cancel Booking</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
    <br>
    <a href="/dashboard">Back to Dashboard</a>
</body>
</html>