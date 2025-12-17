<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking; // Make sure you have this Model
use Illuminate\Support\Facades\Mail;
use App\Mail\RentReminderMail;
use Carbon\Carbon;

class SendRentReminders extends Command
{
    // The name of the command we will run
    protected $signature = 'rent:remind';

    // The description
    protected $description = 'Send reminder emails to users 20 days after booking';

    public function handle()
    {
        // 1. Calculate the date: 20 days ago
        $targetDate = Carbon::now()->subDays(20)->startOfDay();

        // 2. Find bookings made on that EXACT day
        // (We use startOfDay and endOfDay to catch everything from that specific date)
        $bookings = Booking::whereBetween('created_at', [
                        $targetDate, 
                        $targetDate->copy()->endOfDay()
                    ])->get();

        $this->info("Found " . $bookings->count() . " bookings to remind.");

        // 3. Loop through and email them
        foreach ($bookings as $booking) {
            // Check if we have a user to email
            if ($booking->user) {
                try {
                    Mail::to($booking->user->email)->send(new RentReminderMail($booking));
                    $this->info("Email sent to: " . $booking->user->email);
                } catch (\Exception $e) {
                    $this->error("Failed to email: " . $booking->user->email);
                }
            }
        }

        $this->info('All reminders sent successfully!');
    }
}