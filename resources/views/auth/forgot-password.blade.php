<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex align-items-center justify-content-center" style="height: 100vh; background: #f3f4f6;">

    <div class="card shadow p-4" style="width: 400px;">
        <h3 class="text-center mb-3">Reset Password</h3>
        <p class="text-center text-muted small">Enter your email to receive a 4-digit code.</p>

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" required placeholder="example@mail.com">
                @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100">Send Code</button>
        </form>
        
        <div class="text-center mt-3">
            <a href="{{ route('login') }}" class="text-decoration-none">Back to Login</a>
        </div>
    </div>

</body>
</html>