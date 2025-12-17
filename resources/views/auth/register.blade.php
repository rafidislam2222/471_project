<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Rental System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .register-container {
            height: 100%;
            display: flex;
        }

        /* LEFT SIDE: The Image */
        .image-section {
            flex: 1;
            /* Using a different rental image for variety */
            background: url('https://images.unsplash.com/photo-1493809842364-78817add7ffb?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80') no-repeat center center;
            background-size: cover;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
        }

        .image-text {
            position: relative;
            z-index: 2;
            text-align: center;
            padding: 20px;
        }

        .image-text h1 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .image-text p {
            font-size: 1.2rem;
            opacity: 0.9;
        }

        /* RIGHT SIDE: The Form */
        .form-section {
            flex: 0.8;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            overflow-y: auto; /* Allows scrolling if form is tall */
        }

        .form-wrapper {
            width: 100%;
            max-width: 400px;
        }

        .brand-logo {
            font-size: 24px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 20px;
            display: inline-block;
        }

        .form-control, .form-select {
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #e1e1e1;
            background-color: #f9fafb;
        }

        .form-control:focus, .form-select:focus {
            border-color: #2c3e50;
            box-shadow: 0 0 0 3px rgba(44, 62, 80, 0.1);
            background-color: white;
        }

        .btn-primary {
            background-color: #2c3e50;
            border: none;
            padding: 12px;
            font-weight: 600;
            border-radius: 8px;
            width: 100%;
            margin-top: 10px;
        }

        .btn-primary:hover {
            background-color: #1a252f;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .image-section { display: none; }
            .form-section { flex: 1; }
        }
    </style>
</head>
<body>

<div class="register-container">
    
    <div class="image-section">
        <div class="image-overlay"></div>
        <div class="image-text">
            <h1>Join Us Today</h1>
            <p>Create an account to start your journey.</p>
        </div>
    </div>

    <div class="form-section">
        <div class="form-wrapper">
            
            <div class="brand-logo">
                <i class="fas fa-building"></i> Rental System
            </div>

            <h2 class="mb-4 fw-bold">Create Account</h2>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('register') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label class="form-label fw-bold small text-muted">Full Name</label>
                    <input type="text" name="name" class="form-control" placeholder="John Doe" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small text-muted">Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="name@example.com" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small text-muted">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small text-muted">Account Type</label>
                    <select name="role" class="form-select" id="roleSelect" onchange="toggleSuperKey()" required>
                        <option value="user">User (Tenant)</option>
                        <option value="owner">Property Owner</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>

                <div class="mb-3" id="superKeyField" style="display: none;">
                    <label class="form-label fw-bold small text-danger">Super Key (Admin Only)</label>
                    <input type="password" name="super_key" class="form-control border-danger" placeholder="Enter Secret Key">
                    @error('super_key')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Create Account</button>
            </form>

            <div class="text-center mt-4 text-muted small">
                Already have an account? 
                <a href="/login" class="fw-bold text-decoration-none" style="color: #2c3e50;">Login here</a>
            </div>

        </div>
    </div>

</div>

<script>
    function toggleSuperKey() {
        var role = document.getElementById("roleSelect").value;
        var superKeyDiv = document.getElementById("superKeyField");
        
        if (role === "admin") {
            superKeyDiv.style.display = "block";
        } else {
            superKeyDiv.style.display = "none";
        }
    }
</script>

</body>
</html>