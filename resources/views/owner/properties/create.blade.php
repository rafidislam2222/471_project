<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Property</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 500px;
            margin: 30px auto;
            padding: 20px;
        }

        h1 {
            text-align: center;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input, textarea, select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        textarea {
            min-height: 80px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #1e7e34;
        }

        .success-message {
            background-color: #d4edda;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .error-message {
            color: red;
            font-size: 12px;
            margin-top: 3px;
        }
    </style>
</head>
<body>
    <h1>Add New Property</h1>

    @if(session('success'))
        <div class="success-message">{{ session('success') }}</div>
    @endif

    <form action="/owner/properties" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label>Title:</label>
            <input type="text" name="title" required>
        </div>

        <div class="form-group">
            <label>Description:</label>
            <textarea name="description"></textarea>
        </div>

        <div class="form-group">
            <label>Rent Price:</label>
            <input type="number" name="rent_price" min="1" required>
            @error('rent_price')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label>Address:</label>
            <input type="text" name="address" required>
        </div>

        <div class="form-group">
            <label>Availability:</label>
            <select name="availability" required>
                <option value="1">Available</option>
                <option value="0">Not Available</option>
            </select>
        </div>

        <div class="form-group">
            <label>Owner Info:</label>
            <textarea name="owner_info" required></textarea>
        </div>

        <div class="form-group">
            <label>Property Images:</label>
            <input type="file" name="images[]" multiple accept="image/*">
        </div>

        <button type="submit">Save Property</button>
    </form>
</body>
</html>
