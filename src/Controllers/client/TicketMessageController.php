<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\User;
use Fibdesign\Ticket\Models\Ticket;
use Illuminate\Http\Request;

class TicketMessageController extends Controller
{
    public User $user;
    public function __construct()
    {
        $this->user = auth('sanctum')->user();
    }

    public function index($ticket)
    {
        $ticket = Ticket::find($ticket);
        $ticket->update(['seen_at' => now()]);
        return $ticket->messages;
    }

    public function store(Request $request, $ticket)
    {
        $ticket = Ticket::find($ticket);
        $data = $request->validate([
            'content' => 'required',
            'file' => 'nullable',
        ]);
        if ($request->hasFile('file')){
            $data['file'] = $request->file('file')->store("/tickets/$ticket->id", 'files');
        }
        $data['user_id'] = $this->user->id;
        $ticket->messages()->create($data);
        if ($ticket->messages()->count() > 0){
            $ticket->userResponded();
        }else{
            $ticket->open();
        }
        return $ticket->unArchive();
    }
}
