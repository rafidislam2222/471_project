<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    // 1. LIST USERS
    public function index(Request $request)
    {
        $role = $request->query('role');
        $search = $request->input('search'); 

        $query = User::query();

        if (in_array($role, ['user', 'owner', 'admin'])) {
            $query->where('role', $role);
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('id', $search);
            });
        }

        $query->orderBy('created_at', 'desc');

        $users = $query->paginate(10)->withQueryString();

        return view('admin.users.index', [
            'users'       => $users,
            'currentRole' => $role,
            'search'      => $search,
        ]);
    }

    // 2. SHOW USER PROFILE (RENAMED TO FIX ERROR)
    public function showProfile($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.profile', compact('user'));
    }

    // 3. UPDATE ROLE
    public function updateRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:admin,owner,user',
        ]);

        $user = User::findOrFail($id);
        $user->role = $request->role;
        $user->save();

        return redirect()->back()->with('success', "User role updated to {$request->role}.");
    }

    // 4. SUSPEND / UNSUSPEND USER
    public function suspend(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $type = $request->input('type'); 

        if ($type === 'none') {
            $user->status = 'active';
            $user->suspended_until = null;
            $msg = 'User has been reactivated.';
        } 
        elseif ($type === 'permanent') {
            $user->status = 'suspended';
            $user->suspended_until = null; 
            $msg = 'User has been permanently suspended.';
        } 
        else {
            $days = (int) $request->input('days', 7);
            $user->status = 'suspended';
            $user->suspended_until = now()->addDays($days);
            $msg = "User suspended for {$days} days.";
        }

        $user->save();

        return redirect()->back()->with('success', $msg);
    }

    // 5. DELETE USER
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->id == auth()->id()) {
            return redirect()->back()->with('error', 'You cannot delete yourself!');
        }

        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully.');
    }
}