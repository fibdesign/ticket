<?php

namespace Fibdesign\Ticket\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\User;
use Fibdesign\Ticket\Models\Ticket;
use Fibdesign\Ticket\requests\TicketStoreRequest;
use Fibdesign\Ticket\requests\TicketUpdateRequest;

class TicketController extends Controller
{
    public User $user;
    public function __construct()
    {
        $this->user = auth('sanctum')->user();
    }

    public function index()
    {
        return $this->user->tickets;
    }

    public function store(TicketStoreRequest $request)
    {
        $validatedData = $request->validated();
        return $this->user->tickets()->create($validatedData);
    }

    public function show($ticket): Ticket
    {
        return Ticket::find($ticket);
    }

    public function update(TicketUpdateRequest $request,$ticket): bool
    {
        $ticket = Ticket::find($ticket);
        $data = $request->validated();
        match ($data['type']){
            'open' => $ticket->open(),
            'close' => $ticket->close(),
            'seen' => $ticket->seen(),
        };

        return $ticket->save();
    }

}
