<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\SystemNotification;

class AdminNotificationController extends Controller
{
    /**
     * Handle the admin sending a manual notification.
     */
    public function sendNotification(Request $request)
    {
        // 1. Validate the input
        $request->validate([
            'user_id' => 'required|exists:users,id', // Ensure user exists
            'message' => 'required|string|max:255',  // Limit message length
        ]);

        // 2. Find the user
        $user = User::find($request->user_id);

        // 3. Send the notification
        // We pass '#' as the URL since this is just a generic message
        $user->notify(new SystemNotification($request->message, '#'));

        // 4. Return back with a success message
        return back()->with('success', 'Notification sent successfully!');
    }
}