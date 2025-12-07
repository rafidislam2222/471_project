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
