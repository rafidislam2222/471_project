<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Booking; // Assuming you have a Booking model

class RentReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;

    public function __construct($booking)
    {
        $this->booking = $booking;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Rent Payment Reminder',
        );
    }

    public function content(): Content
    {
        // We will send a simple HTML message directly
        return new Content(
            htmlString: '
                <h1>Rent Reminder</h1>
                <p>Hello,</p>
                <p>This is a gentle reminder regarding your booking for <strong>' . $this->booking->property->title . '</strong>.</p>
                <p>It has been 20 days since your booking. Please ensure your rent payment is up to date.</p>
                <p>Thank you!</p>
            '
        );
    }
}