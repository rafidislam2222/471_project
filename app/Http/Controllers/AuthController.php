<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required',
            'role'     => 'required|in:user,owner,admin'
        ]);


        ///add superkey validation for admin role
        $role=$request->role;
        if ($role === 'admin') {
            $superKeyFromForm = $request->input('super_key');
            $expectedKey      = config('app.super_admin_key');

            if (!$expectedKey || $superKeyFromForm !== $expectedKey) {
                return back()
                    ->withErrors([
                        'super_key' => 'Invalid or missing super key for admin registration.'
                    ])
                    ->withInput();
            }
        }


        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        return redirect('/login')->with('success', 'Account created successfully!');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return back()->with('error', 'Invalid email or password');
        }

        $user = Auth::user();
//suspend if  the user is suspended not logged in
        if ($user->status == 'suspended') {
            $now = now();
            if ($user->suspended_until && $now->lessThan($user->suspended_until)) {
                $suspendUntil = $user->suspended_until->toDateTimeString();
                Auth::logout();
                return back()->with('error', "Your account is suspended until {$suspendUntil}.");
            } else {
                // Lift suspension
                $user->status = 'active';
                $user->suspended_until = null;
                $user->save();
            }
        }

        // Redirect based on role
        if ($user->role == 'admin') {
            return redirect('/admin/dashboard');
        }
        if ($user->role == 'owner') {
            return redirect('/owner/dashboard');
        }
        return redirect('/user/dashboard');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
