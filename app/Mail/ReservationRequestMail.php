<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReservationRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $bookingData;
    public $isAdmin;

    /**
     * Create a new message instance.
     *
     * @param array $bookingData
     * @param bool $isAdmin
     */
    public function __construct($bookingData, $isAdmin = false)
    {
        $this->bookingData = $bookingData;
        $this->isAdmin = $isAdmin;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->isAdmin 
            ? 'New Reservation Request: ' . $this->bookingData['hotel_name']
            : 'Booking Request Received - Sentra Hotels';

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.reservation',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
