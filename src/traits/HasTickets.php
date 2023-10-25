<?php

namespace Fibdesign\Ticket\traits;

use Fibdesign\Ticket\Models\Ticket;
use Fibdesign\Ticket\Models\TicketMessage;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasTickets
{
    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class, 'user_id');
    }
}
