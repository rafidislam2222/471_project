<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Property; // Assuming your Property model is here

class NewPropertyNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $property; // Public property to pass data to the view

    /**
     * Create a new message instance.
     */
    public function __construct(Property $property)
    {
        $this->property = $property;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'NEW PROPERTY ALERT: ' . $this->property->title,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.properties.new_property_alert', // We will create this view next
            // Pass the property variable to the view
            with: ['property' => $this->property] 
        );
    }
}