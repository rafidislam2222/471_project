<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Rental System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-container {
            height: 100%;
            display: flex;
        }

        /* LEFT SIDE: The Image */
        .image-section {
            flex: 1;
            /* Using a high-quality building/rental image */
            background: url('https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80') no-repeat center center;
            background-size: cover;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        /* Dark Overlay */
        .image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6); /* Slightly darker for better text readability */
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
        }

        .form-wrapper {
            width: 100%;
            max-width: 400px;
        }

        .brand-logo {
            font-size: 24px;
            font-weight: bold;
            color: #2c3e50; /* Professional Dark Blue/Grey */
            margin-bottom: 30px;
            display: inline-block;
        }

        .form-control {
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #e1e1e1;
            background-color: #f9fafb;
        }

        .form-control:focus {
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
            .image-section {
                display: none; 
            }
            .form-section {
                flex: 1;
            }
        }
    </style>
</head>
<body>

<div class="login-container">
    
    <div class="image-section">
        <div class="image-overlay"></div>
        <div class="image-text">
            <h1>Find Your Space</h1>
            <p>Seamless property management and rentals.</p>
        </div>
    </div>

    <div class="form-section">
        <div class="form-wrapper">
            
            <div class="brand-logo">
                <i class="fas fa-building"></i> Rental System
            </div>

            <h2 class="mb-4 fw-bold">Welcome Back</h2>
            <p class="text-muted mb-4">Please enter your details to sign in.</p>

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label class="form-label fw-bold small text-muted">Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="name@example.com" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small text-muted">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="remember">
                        <label class="form-check-label small" for="remember">Remember me</label>
                    </div>
                    <a href="/forgot-password" class="small text-decoration-none" style="color: #2c3e50;">Forgot Password?</a>
                </div>

                <button type="submit" class="btn btn-primary">Sign In</button>
            </form>

            <div class="text-center mt-4 text-muted small">
                Don't have an account? 
                <a href="/register" class="fw-bold text-decoration-none" style="color: #2c3e50;">Create an account</a>
            </div>

        </div>
    </div>

</div>

</body>
</html>