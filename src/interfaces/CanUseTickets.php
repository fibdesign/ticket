<?php

namespace Fibdesign\Ticket\interfaces;

use Illuminate\Database\Eloquent\Relations\HasMany;

interface CanUseTickets
{
    public function tickets(): HasMany;
}
