<?php

namespace Fibdesign\Ticket\observers;

use Fibdesign\Ticket\mails\TicketMail;
use Fibdesign\Ticket\mails\TicketUpdateMail;
use Fibdesign\Ticket\Models\Ticket;
use Illuminate\Support\Facades\Mail;
use function PHPUnit\Framework\isEmpty;

class TicketObserver
{
    public function created(Ticket $ticket): void
    {
        if ($ticket->user && $ticket->user->email){
            Mail::to($ticket->user)->queue(new TicketMail($ticket));
        }
    }

    public function updated(Ticket $ticket): void
    {
    }

    public function deleted(Ticket $ticket): void
    {
    }

    public function restored(Ticket $ticket): void
    {
    }

    public function forceDeleted(Ticket $ticket): void
    {
    }
}
