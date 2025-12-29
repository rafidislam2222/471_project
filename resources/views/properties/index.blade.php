<!DOCTYPE html>
<html>
<head>
    <title>Properties - Premium Rental System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
            color: #333;
        }

        /* HEADER & NOTIFICATION BAR */
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .navbar-brand {
            color: white;
            font-size: 20px;
            font-weight: bold;
            text-decoration: none;
        }

        .navbar-actions {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .notification-btn {
            background: rgba(255,255,255,0.2);
            border: none;
            color: white;
            font-size: 20px;
            cursor: pointer;
            position: relative;
            padding: 8px 12px;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .notification-btn:hover {
            background: rgba(255,255,255,0.3);
        }

        .notification-badge {
            background: #ff6b6b;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 10px;
            position: absolute;
            top: -5px;
            right: -5px;
        }

        .notification-dropdown {
            display: none;
            position: absolute;
            right: 0;
            top: 100%;
            background: white;
            border: 1px solid #ddd;
            width: 350px;
            border-radius: 8px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.12);
            z-index: 1000;
            margin-top: 10px;
        }

        .notification-dropdown.show {
            display: block;
        }

        .notification-dropdown-header {
            padding: 15px;
            border-bottom: 1px solid #eee;
            font-weight: 600;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .notification-dropdown-list {
            list-style: none;
            max-height: 400px;
            overflow-y: auto;
        }

        .notification-item {
            padding: 15px;
            border-bottom: 1px solid #eee;
            font-size: 14px;
            transition: background 0.2s;
        }

        .notification-item:hover {
            background: #f8f9fa;
        }

        .notification-time {
            color: #999;
            font-size: 12px;
            margin-top: 5px;
        }

        .notification-empty {
            padding: 20px;
            text-align: center;
            color: #999;
        }

        .logout-btn {
            background: rgba(255,255,255,0.2);
            border: none;
            color: white;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
            font-weight: 500;
        }

        .logout-btn:hover {
            background: rgba(255,255,255,0.3);
        }

        /* MAIN CONTENT */
        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 30px;
            padding: 10px 16px;
            background: white;
            color: #667eea;
            text-decoration: none;
            border-radius: 6px;
            border: 1px solid #ddd;
            transition: all 0.3s;
            font-weight: 500;
        }

        .back-btn:hover {
            background: #f8f9fa;
            border-color: #667eea;
        }

        .page-header {
            margin-bottom: 40px;
        }

        .page-header h1 {
            font-size: 32px;
            color: #1a1a1a;
            margin-bottom: 10px;
        }

        .page-header p {
            color: #666;
            font-size: 16px;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* SEARCH FORM */
        .search-section {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            margin-bottom: 40px;
        }

        .search-section h2 {
            font-size: 20px;
            margin-bottom: 20px;
            color: #1a1a1a;
        }

        .search-form {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr auto auto;
            gap: 15px;
            align-items: end;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            font-weight: 600;
            margin-bottom: 8px;
            color: #333;
            font-size: 14px;
        }

        .form-group input {
            padding: 10px 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            transition: border-color 0.3s;
        }

        .form-group input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .search-btn {
            padding: 10px 24px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .search-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        .reset-btn {
            padding: 10px 24px;
            background: #e9ecef;
            color: #333;
            text-decoration: none;
            border-radius: 6px;
            border: 1px solid #ddd;
            font-weight: 600;
            transition: background 0.2s;
            display: inline-block;
        }

        .reset-btn:hover {
            background: #dee2e6;
        }

        /* PROPERTIES GRID */
        .properties-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .properties-count {
            color: #666;
            font-size: 16px;
        }

        .properties-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .property-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
        }

        .property-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.12);
        }

        .property-images {
            position: relative;
            width: 100%;
            height: 200px;
            overflow: hidden;
            background: #f0f0f0;
        }

        .property-images img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s;
        }

        .property-card:hover .property-images img {
            transform: scale(1.05);
        }

        .property-no-image {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #999;
            font-style: italic;
        }

        .property-content {
            padding: 20px;
        }

        .property-title {
            font-size: 18px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 10px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .property-address {
            color: #666;
            font-size: 14px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .property-price {
            font-size: 24px;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 15px;
        }

        .property-price-label {
            font-size: 12px;
            color: #999;
            font-weight: normal;
        }

        .property-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 15px;
            border-top: 1px solid #eee;
        }

        .property-status {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-available {
            background: #d4edda;
            color: #155724;
        }

        .status-booked {
            background: #f8d7da;
            color: #721c24;
        }

        .view-btn {
            padding: 8px 16px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            font-size: 14px;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .view-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        .no-properties {
            text-align: center;
            padding: 60px 20px;
            color: #666;
        }

        .no-properties-icon {
            font-size: 48px;
            margin-bottom: 20px;
            color: #ccc;
        }

        /* RESPONSIVE */
        @media (max-width: 1024px) {
            .properties-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            }

            .search-form {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 640px) {
            .properties-grid {
                grid-template-columns: 1fr;
            }

            .search-form {
                grid-template-columns: 1fr;
            }

            .navbar {
                flex-direction: column;
                gap: 15px;
            }

            .page-header h1 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>

{{-- NOTIFICATION BAR --}}
<div class="navbar">
    <div class="navbar-brand">🏠 RentalHub</div>

    <div class="navbar-actions">
        @auth
            <div style="position: relative;">
                <button class="notification-btn" onclick="document.getElementById('notif-dropdown').classList.toggle('show')">
                    <i class="fas fa-bell"></i>
                    @if(auth()->user()->unreadNotifications->count() > 0)
                        <span class="notification-badge">{{ auth()->user()->unreadNotifications->count() }}</span>
                    @endif
                </button>

                <div id="notif-dropdown" class="notification-dropdown">
                    <div class="notification-dropdown-header">
                        <span>Notifications</span>
                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <a href="{{ route('notifications.read') }}" style="font-size: 12px; color: #667eea; text-decoration: none; font-weight: 600;">Mark all read</a>
                        @endif
                    </div>

                    <ul class="notification-dropdown-list">
                        @forelse(auth()->user()->unreadNotifications as $notification)
                            <li class="notification-item">
                                {{ $notification->data['message'] ?? 'New Notification' }}
                                <div class="notification-time">{{ $notification->created_at->diffForHumans() }}</div>
                            </li>
                        @empty
                            <li class="notification-empty">No new notifications</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="logout-btn">Login</a>
        @endauth
    </div>
</div>

{{-- MAIN CONTENT --}}
<div class="container">
    <a href="/user/dashboard" class="back-btn">
        <i class="fas fa-arrow-left"></i> Back to Dashboard
    </a>

    <div class="page-header">
        <h1>Explore Properties</h1>
        <p>Find your perfect rental property</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
        </div>
    @endif

    {{-- SEARCH SECTION --}}
    <div class="search-section">
        <h2>Search Properties</h2>
        <form method="GET" action="/properties" class="search-form">
            <div class="form-group">
                <label>Location</label>
                <input type="text" name="address" placeholder="Enter address" value="{{ request('address') }}">
            </div>

            <div class="form-group">
                <label>Min Price</label>
                <input type="number" name="min_price" placeholder="0" value="{{ request('min_price') }}">
            </div>

            <div class="form-group">
                <label>Max Price</label>
                <input type="number" name="max_price" placeholder="10000" value="{{ request('max_price') }}">
            </div>

            <button type="submit" class="search-btn">
                <i class="fas fa-search"></i> Search
            </button>
            <a href="/properties" class="reset-btn">
                <i class="fas fa-redo"></i> Reset
            </a>
        </form>
    </div>

    {{-- PROPERTIES GRID --}}
    @if($properties->count() > 0)
        <div class="properties-header">
            <h2 style="margin: 0;">Available Properties</h2>
            <span class="properties-count">{{ $properties->count() }} properties found</span>
        </div>

        <div class="properties-grid">
            @foreach($properties as $property)
            <div class="property-card">
                {{-- IMAGES --}}
                <div class="property-images">
                    @php
                        $images = is_array($property->images)
                                ? $property->images
                                : (json_decode($property->images, true) ?? []);
                    @endphp

                    @if(!empty($images))
                        <img src="{{ asset('storage/property_images/'.$images[0]) }}" alt="{{ $property->title }}">
                    @else
                        <div class="property-no-image">
                            <i class="fas fa-image"></i> No Images
                        </div>
                    @endif
                </div>

                {{-- CONTENT --}}
                <div class="property-content">
                    <h3 class="property-title">{{ $property->title }}</h3>
                    
                    <div class="property-address">
                        <i class="fas fa-map-marker-alt"></i>
                        {{ $property->address }}
                    </div>

                    <div class="property-price">
                        <span class="property-price-label">₱</span>{{ number_format($property->rent_price, 0) }}
                        <span class="property-price-label">/month</span>
                    </div>

                    <div class="property-footer">
                        <span class="property-status {{ $property->availability == 1 ? 'status-available' : 'status-booked' }}">
                            {{ $property->availability == 1 ? '✓ Available' : '✗ Booked' }}
                        </span>
                        <a href="/properties/{{ $property->id }}" class="view-btn">View Details</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="no-properties">
            <div class="no-properties-icon">
                <i class="fas fa-search"></i>
            </div>
            <h3>No Properties Found</h3>
            <p>Try adjusting your search filters or <a href="/properties" style="color: #667eea; text-decoration: none;">view all properties</a></p>
        </div>
    @endif
</div>

<script>
    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        const dropdown = document.getElementById('notif-dropdown');
        const button = e.target.closest('.notification-btn');
        if (!button && dropdown.classList.contains('show')) {
            dropdown.classList.remove('show');
        }
    });
</script>

</body>
</html>
