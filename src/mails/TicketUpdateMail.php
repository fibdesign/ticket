<?php

namespace Fibdesign\Ticket\mails;

use Fibdesign\Ticket\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TicketUpdateMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public Ticket $ticket)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'پاسخ به تیکت شما',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'ticket::emails.ticketUpdate',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
