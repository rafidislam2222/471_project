<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Rent; 
use App\Notifications\SystemNotification;

class SendRentReminders extends Command
{
    protected $signature = 'rent:remind';
    protected $description = 'Send notifications for rent due tomorrow';
    public function handle()
    {
        // 1. Find rents due tomorrow that are unpaid
        // Note: Make sure 'due_date' and 'status' match your database column names
        $dueTomorrow = Rent::where('due_date', now()->addDay()->toDateString())
                        ->where('status', 'unpaid')
                        ->get();

        // 2. Loop through and notify
        foreach ($dueTomorrow as $rent) {
            // Assuming your Rent model has a 'tenant' relationship to User
            $user = $rent->tenant; 
            
            if ($user) {
                $user->notify(new SystemNotification(
                    "Reminder: Your rent of \${$rent->amount} is due tomorrow.",
                    url('/payments')
                ));
            }
        }

        $this->info('Rent reminders sent successfully!');
    }
}