<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    // --- PAGE 1: Ask for Email ---
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    // --- ACTION: Generate OTP & Send Email ---
    public function sendOtp(Request $request)
    {
        // 1. Validate email exists
        $request->validate(['email' => 'required|email|exists:users,email']);
        $email = $request->email;
        
        // 2. Generate random 4-digit code
        $otp = rand(1000, 9999);

        // 3. Save OTP in Cache for 10 minutes
        Cache::put('otp_' . $email, $otp, now()->addMinutes(10));

        // 4. Send Email DIRECTLY (Fixes blank email issue)
        try {
            // We use Mail::html to force the text into the email.
            // This bypasses the View file entirely.
            $messageBody = "<h1>Password Reset</h1>
                            <p>Your OTP Code is: <strong style='font-size:24px;'>$otp</strong></p>
                            <p>This code expires in 10 minutes.</p>";

            Mail::html($messageBody, function ($message) use ($email) {
                $message->to($email);
                $message->subject('Your Password Reset Code');
            });

        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Failed to send email. Try again later.']);
        }

        // 5. REDIRECT to Page 2 (Pass email in URL so we know who it is)
        return redirect()->route('password.reset', ['email' => $email])
                         ->with('success', 'Code sent! Check your inbox.');
    }

    // --- PAGE 2: Ask for OTP + New Password ---
    public function showResetForm(Request $request)
    {
        // We capture the email from the URL so we can put it in a hidden field
        return view('auth.reset-password', ['email' => $request->email]);
    }

    // --- ACTION: Verify OTP & Update Password ---
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email'    => 'required|email|exists:users,email',
            'otp'      => 'required|numeric',
            'password' => 'required|min:8|confirmed'
        ]);

        // 1. Check if OTP matches the one in Cache
        $cachedOtp = Cache::get('otp_' . $request->email);

        if (!$cachedOtp || $cachedOtp != $request->otp) {
            return back()->withErrors(['otp' => 'Wrong or expired code.']);
        }

        // 2. Update Password
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // 3. Clear OTP
        Cache::forget('otp_' . $request->email);

        // 4. Send to Login
        return redirect('/login')->with('success', 'Password changed! Please login.');
    }
}