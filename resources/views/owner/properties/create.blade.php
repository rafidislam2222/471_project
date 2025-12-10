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
    <input type="text" name="title" value="{{ old('title') }}" required><br>
    @error('title')
        <p style="color:red; margin-top:4px;">{{ $message }}</p>
    @enderror
    <br>

    <label>Description:</label>
    <textarea name="description">{{ old('description') }}</textarea><br>
    @error('description')
        <p style="color:red; margin-top:4px;">{{ $message }}</p>
    @enderror
    <br>

    <label>Rent Price:</label>
    <input type="number" name="rent_price" min="1" value="{{ old('rent_price') }}" required><br>
    @error('rent_price')
        <p style="color:red; margin-top:4px;">{{ $message }}</p>
    @enderror

    <br>


    <label>Address:</label>
    <input type="text" name="address" value="{{ old('address') }}" required><br><br>
    @error('address')
        <p style="color:red; margin-top:4px;">{{ $message }}</p>
    @enderror

    <label>Availability:</label>
    <select name="availability" required>
        <option value="1" {{ old('availability') === '1' ? 'selected' : '' }}>Available</option>
        <option value="0" {{ old('availability') === '0' ? 'selected' : '' }}>Not Available</option>
    </select><br><br>
    @error('availability')
        <p style="color:red; margin-top:4px;">{{ $message }}</p>
    @enderror

    <label>Owner Info:</label>
    <textarea name="owner_info" required>{{ old('owner_info') }}</textarea><br><br>
    @error('owner_info')
        <p style="color:red; margin-top:4px;">{{ $message }}</p>
    @enderror

    <!-- NEW: MULTIPLE IMAGES UPLOAD -->
    <label>Property Images:</label>
    <input type="file" name="images[]" multiple accept="image/*"><br><br>
    @error('images')
        <p style="color:red; margin-top:4px;">{{ $message }}</p>
    @enderror
    @error('images.*')
        <p style="color:red; margin-top:4px;">{{ $message }}</p>
    @enderror

    <button type="submit">Save Property</button>

</form>

</body>
</html>