<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OTPMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp; // This public variable is AUTOMATICALLY sent to the view

    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Your Password Reset Code');
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.auth.otp', // Ensure this matches your folder name exactly
        );
    }
}