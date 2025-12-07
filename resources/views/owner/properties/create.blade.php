<!DOCTYPE html>
<html>
<head>
    <title>Add Property</title>
</head>
<body>

<h1>Add New Property</h1>

{{-- Success message --}}
@if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif

<form action="/owner/properties" method="POST" enctype="multipart/form-data">

    @csrf

    <label>Title:</label>
    <input type="text" name="title" required><br><br>

    <label>Description:</label>
    <textarea name="description"></textarea><br><br>

    <label>Rent Price:</label>
    <input type="number" name="rent_price" required><br><br>

    <label>Address:</label>
    <input type="text" name="address" required><br><br>

    <label>Availability:</label>
    <select name="availability" required>
        <option value="1">Available</option>
        <option value="0">Not Available</option>
    </select><br><br>

    <label>Owner Info:</label>
    <textarea name="owner_info" required></textarea><br><br>

    <!-- NEW: MULTIPLE IMAGES UPLOAD -->
    <label>Property Images:</label>
    <input type="file" name="images[]" multiple accept="image/*"><br><br>

    <button type="submit">Save Property</button>

</form>

</body>
</html>
