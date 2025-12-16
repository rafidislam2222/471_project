<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    // Show the form to enter email
    public function showForgotForm()
    {
        return view('forgot-password'); 
    }

    // Generate OTP and Send Email
    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $user = User::where('email', $request->email)->first();

        // Generate a random 6-digit code
        $otp = rand(100000, 999999);

        // Save OTP to the user's record in the database
        $user->otp = $otp;
        $user->save();

        // Send Email (Simple text email)
        // NOTE: Make sure your .env file has MAIL settings configured!
        Mail::raw("Your OTP for password reset is: $otp", function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Password Reset OTP');
        });

        return redirect('/reset-password')->with('success', 'OTP sent to your email! Please check it.');
    }

    // Show the form to enter OTP and new password
    public function showResetForm()
    {
        return view('reset-password');
    }

    // Verify OTP and Update Password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required',
            'password' => 'required|min:6|confirmed', // 'confirmed' checks if password matches password_confirmation
        ]);

        // Find user with this email AND this OTP
        $user = User::where('email', $request->email)
                    ->where('otp', $request->otp)
                    ->first();

        if (!$user) {
            return back()->with('error', 'Invalid OTP or Email.');
        }

        // Update password
        $user->password = Hash::make($request->password);
        $user->otp = null; // Clear the OTP so it can't be used again
        $user->save();

        return redirect('/login')->with('success', 'Password reset successfully! You can login now.');
    }
}