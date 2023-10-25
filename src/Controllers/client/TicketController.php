<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\User;
use Fibdesign\Ticket\Models\Ticket;
use Illuminate\Http\Request;

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

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'subject' => 'required',
            'priority' => 'required',
            'category_id' => 'nullable',
        ]);
        return $this->user->tickets()->create($validatedData);
    }

    public function show($ticket): Ticket
    {
        return Ticket::find($ticket);
    }

    public function update(Request $request,$ticket): bool
    {
        $ticket = Ticket::find($ticket);
        $data = $request->validate([
            'type' => 'required',
            'user' => 'nullable'
        ]);
        match ($data['type']){
            'open' => $ticket->open(),
            'close' => $ticket->close(),
            'seen' => $ticket->seen(),
        };

        return $ticket->save();
    }

}
