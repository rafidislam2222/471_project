<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        // Get all notifications for the user
        $notifications = Auth::user()->notifications;

        // Mark them all as "Read" when the user visits this page
        Auth::user()->unreadNotifications->markAsRead();

        return view('dashboard.notifications', compact('notifications'));
    }
}