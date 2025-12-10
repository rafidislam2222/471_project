<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    // 1 View all users (with role filter + search)
    public function index(Request $request)
    {
        // Read role filter from URL: ?role=admin / owner / user
        $role = $request->query('role');

        // Read search text: ?search=...
        $search = $request->query('search');

        $query = User::query();

        // Filter by role, if valid//The Boxes
        if (in_array($role, ['user', 'owner', 'admin'])) {
            $query->where('role', $role);
        }

        // Filter by search, if provided
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('id', $search); // exact match for ID
            });
        }

        $users = $query->get();

        return view('admin.users.index', [
            'users'       => $users,
            'currentRole' => $role,
            'search'      => $search,
        ]);
    }

    //Change user role
    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:user,owner,admin',
        ]);

        $user->role = $request->role;
        $user->save();

        return back()->with('success', 'User role updated.');
    }

    // Suspend / unsuspend user (temporary or permanent)
    public function suspend(Request $request, User $user)
    {
        $request->validate([
            'type' => 'required|in:none,temporary,permanent',
            'days' => 'nullable|integer|min:1', // used for temporary
        ]);

        if ($request->type === 'none') {
            // remove suspension
            $user->status = 'active';
            $user->suspended_until = null;
        } elseif ($request->type === 'temporary') {
            $days = $request->days;
            if ($days === null || $days === '') {
                $days = 7; // default 7 days
            }
            $days = (int) $days;

            $user->status = 'suspended';
            $user->suspended_until = now()->addDays($days);
        } elseif ($request->type === 'permanent') {
            $user->status = 'suspended';
            $user->suspended_until = null; // null = permanent
        }

        $user->save();

        return back()->with('success', 'User suspension updated.');
    }

    //Permanently delete a user
    public function destroy(User $user)
    {
        $user->delete();

        return back()->with('success', 'User account deleted.');
    }

    // View user profile
    public function showProfile(User $user)
    {
        return view('admin.users.profile', compact('user'));
    }
}
