<h2>Edit Property</h2>

<form action="/owner/properties/{{ $property['id'] }}/update" method="POST">
    @csrf

    <input type="text" name="title" value="{{ $property['title'] }}"><br><br>
    <textarea name="description">{{ $property['description'] }}</textarea><br><br>
    <input type="number" name="rent_price" value="{{ $property['rent_price'] }}"><br><br>
    <input type="text" name="address" value="{{ $property['address'] }}"><br><br>

    <select name="availability">
        <option value="1" {{ $property['availability'] ? 'selected' : '' }}>Available</option>
        <option value="0" {{ !$property['availability'] ? 'selected' : '' }}>Not Available</option>
    </select><br><br>

    <input type="text" name="owner_info" value="{{ $property['owner_info'] }}"><br><br>

    <button type="submit">Update Property</button>
</form>
