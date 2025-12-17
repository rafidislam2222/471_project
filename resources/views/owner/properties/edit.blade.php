<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Edit Property</title>
	<style>
		/* Basic page and form styles */
		body {
			font-family: Arial, Helvetica, sans-serif;
			background: #f7f9fb;
			color: #222;
			line-height: 1.4;
			padding: 24px;
		}
		.container {
			max-width: 760px;
			margin: 24px auto;
			background: #fff;
			border: 1px solid #e2e8f0;
			border-radius: 8px;
			padding: 20px 24px;
			box-shadow: 0 2px 6px rgba(16,24,40,0.04);
		}
		h2 {
			margin-top: 0;
			font-size: 20px;
			color: #0f172a;
		}
		form {
			margin-top: 12px;
		}
		label {
			display: block;
			font-weight: 600;
			margin-bottom: 6px;
			color: #0b1220;
		}
		input[type="text"],
		input[type="number"],
		textarea,
		select {
			width: 100%;
			box-sizing: border-box;
			padding: 8px 10px;
			border: 1px solid #cbd5e1;
			border-radius: 6px;
			font-size: 14px;
			margin-bottom: 12px;
			background: #fff;
		}
		textarea {
			min-height: 100px;
			resize: vertical;
		}
		.error-list {
			background: #fff5f5;
			border: 1px solid #fecaca;
			color: #9b1c1c;
			padding: 10px 12px;
			border-radius: 6px;
			margin-bottom: 12px;
		}
		.field-error {
			color: #b91c1c;
			font-size: 13px;
			margin-top: -8px;
			margin-bottom: 12px;
		}
		button[type="submit"] {
			background: #0369a1;
			color: #fff;
			padding: 10px 16px;
			border: none;
			border-radius: 6px;
			cursor: pointer;
			font-weight: 600;
		}
		button[type="submit"]:hover {
			background: #075985;
		}
		.back-link {
			display: inline-block;
			margin-top: 14px;
			color: #0369a1;
			text-decoration: none;
		}
		.back-link:hover { text-decoration: underline; }
		@media (max-width: 520px) {
			.container { padding: 12px; }
			button[type="submit"] { width: 100%; }
		}
	</style>
</head>
<body>
	<div class="container">
		<h2>Edit Property</h2>

		<!-- Show Validation Errors -->
		@if($errors->any())
		    <div class="error-list">
		        <ul style="margin:0; padding-left:18px;">
		            @foreach ($errors->all() as $e)
		                <li>{{ $e }}</li>
		            @endforeach
		        </ul>
		    </div>
		@endif

		<form action="/owner/properties/{{ $property['id'] }}/update" method="POST">
		    @csrf

		    <!-- Title -->
		    <label for="title">Title:</label>
		    <input id="title" class="form-input" type="text" name="title" value="{{ $property['title'] }}" required>

		    <!-- Description -->
		    <label for="description">Description:</label>
		    <textarea id="description" class="form-input" name="description">{{ $property['description'] }}</textarea>

		    <!-- Rent Price -->
		    <label for="rent_price">Rent Price:</label>
		    <input id="rent_price" class="form-input" type="number" name="rent_price" value="{{ $property['rent_price'] }}" min="1" required>
		    @error('rent_price')
		        <p class="field-error">{{ $message }}</p>
		    @enderror

		    <!-- Address -->
		    <label for="address">Address:</label>
		    <input id="address" class="form-input" type="text" name="address" value="{{ $property['address'] }}" required>

		    <!-- Availability -->
		    <label for="availability">Availability:</label>
		    <select id="availability" class="form-input" name="availability" required>
		        <option value="1" {{ $property['availability'] ? 'selected' : '' }}>Available</option>
		        <option value="0" {{ !$property['availability'] ? 'selected' : '' }}>Not Available</option>
		    </select>

		    <!-- Owner Info -->
		    <label for="owner_info">Owner Info:</label>
		    <input id="owner_info" class="form-input" type="text" name="owner_info" value="{{ $property['owner_info'] }}" required>

		    <button type="submit">Update Property</button>
		</form>

		<br>
		<a class="back-link" href="/owner/properties">⬅ Back</a>
	</div>
</body>
</html>
