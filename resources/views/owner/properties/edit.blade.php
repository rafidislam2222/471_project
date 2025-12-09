<h2>Edit Property</h2>

<!-- Show Validation Errors -->
@if($errors->any())
    <div style="color:red;">
        <ul>
            @foreach ($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="/owner/properties/{{ $property['id'] }}/update" method="POST">
    @csrf

    <!-- Title -->
    <label>Title:</label><br>
    <input type="text" name="title" value="{{ $property['title'] }}" required><br><br>

    <!-- Description -->
    <label>Description:</label><br>
    <textarea name="description">{{ $property['description'] }}</textarea><br><br>

    <!-- Rent Price -->
    <label>Rent Price:</label><br>
    <input type="number" name="rent_price" value="{{ $property['rent_price'] }}" min="1" required><br>
    @error('rent_price')
        <p style="color:red;">{{ $message }}</p>
    @enderror
    <br>

    <!-- Address -->
    <label>Address:</label><br>
    <input type="text" name="address" value="{{ $property['address'] }}" required><br><br>

    <!-- Availability -->
    <label>Availability:</label><br>
    <select name="availability" required>
        <option value="1" {{ $property['availability'] ? 'selected' : '' }}>Available</option>
        <option value="0" {{ !$property['availability'] ? 'selected' : '' }}>Not Available</option>
    </select><br><br>

    <!-- Owner Info -->
    <label>Owner Info:</label><br>
    <input type="text" name="owner_info" value="{{ $property['owner_info'] }}" required><br><br>

    <button type="submit">Update Property</button>
</form>

<br>
<a href="/owner/properties">⬅ Back</a>
