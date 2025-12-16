<!DOCTYPE html>
<html>
<head>
    <title>Change Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex align-items-center justify-content-center" style="height: 100vh; background: #f3f4f6;">

    <div class="card shadow p-4" style="width: 400px;">
        <h3 class="text-center mb-3">Enter Code & New Password</h3>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            
            <input type="hidden" name="email" value="{{ request('email') }}">

            <div class="mb-3">
                <label class="form-label">4-Digit Code (Check Email)</label>
                <input type="text" name="otp" class="form-control text-center" 
                       style="letter-spacing: 5px; font-weight: bold; font-size: 20px;" 
                       maxlength="4" required placeholder="0000">
                @error('otp') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">New Password</label>
                <input type="password" name="password" class="form-control" required placeholder="Min 8 chars">
                @error('password') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" required placeholder="Retype password">
            </div>

            <button type="submit" class="btn btn-primary w-100">Change Password</button>
        </form>
    </div>

</body>
</html>