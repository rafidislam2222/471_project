<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Property;

class NewPropertyNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $property;

    public function __construct(Property $property)
    {
        $this->property = $property;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'NEW PROPERTY ALERT: ' . $this->property->title,
        );
    }

    // REMOVED: via() and toMail() - These do not belong here!

    public function content(): Content
    {
        // This tells Laravel to look for the HTML design in resources/views/emails/properties/
        return new Content(
            markdown: 'email.properties.new_property_alart',
            with: ['property' => $this->property]
        );
    }
}