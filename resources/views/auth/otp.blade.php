<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; background-color: #f4f4f4; padding: 20px; }
        .box { max-width: 400px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; text-align: center; }
        .code { font-size: 32px; font-weight: bold; letter-spacing: 5px; color: #4F46E5; margin: 20px 0; }
    </style>
</head>
<body>
    <div class="box">
        <h2>Password Reset</h2>
        <p>Use the code below to reset your password. It expires in 10 minutes.</p>
        <div class="code">{{ $otp }}</div>
        <p>If you did not request this, please ignore this email.</p>
    </div>
</body>
</html>