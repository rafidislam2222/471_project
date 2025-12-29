<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; background-color: #ffffff; color: #333; line-height: 1.6; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .btn {
            background-color: #4F46E5; color: white; padding: 10px 20px;
            text-decoration: none; border-radius: 5px; display: inline-block; margin-top: 15px;
        }
        h2 { color: #4F46E5; }
        .label { font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <h2>New Property Alert!</h2>
        
        <p>A new property has just been listed: <strong>{{ $property->title }}</strong></p>
        
        <p>
            <span class="label">Rent:</span> ${{ number_format($property->rent_price) }}<br>
            <span class="label">Address:</span> {{ $property->address }}
        </p>

        <p>{{ Str::limit($property->description, 100) }}</p>

        <a href="{{ url('/properties/' . $property->id) }}" class="btn">
            View Property Details
        </a>

        <p style="margin-top: 30px; font-size: 12px; color: #888;">
            Thanks,<br>
            {{ config('app.name') }}
        </p>
    </div>
</body>
</html>