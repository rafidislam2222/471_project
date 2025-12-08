<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    // 1️⃣ View all users
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    // 2️⃣ Change user role
    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:user,owner,admin',
        ]);

        $user->role = $request->role;
        $user->save();

        return back()->with('success', 'User role updated.');
    }

    // 3️⃣ Suspend / unsuspend user (temporary or permanent)
    public function suspend(Request $request, User $user)
    {
        $request->validate([
            'type'      => 'required|in:none,temporary,permanent',
            'days'      => 'nullable|integer|min:1', // used for temporary
        ]);

        if ($request->type === 'none') {
            // remove suspension
            $user->status = 'active';
            $user->suspended_until = null;
        } elseif ($request->type === 'temporary') {

            $days = $request->days; // default 7 days
            if ($days==null||$days === '') {
                $days=7;
            }
            $days = (int)$days;
            $user->status = 'suspended';
            $user->suspended_until = now()->addDays($days);
        } elseif ($request->type === 'permanent') {
            $user->status = 'suspended';
            $user->suspended_until = null; // null = permanent
        }

        $user->save();

        return back()->with('success', 'User suspension updated.');
    }

    // 4️⃣ Permanently delete a user
    public function destroy(User $user)
    {
        $user->delete();

        return back()->with('success', 'User account deleted.');
    }
    // 5️⃣ View user profile
    public function showProfile(User $user)
    {
        return view('admin.users.profile', compact('user'));
    }
}
