<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Fibdesign\Ticket\mails\TicketUpdateMail;
use Fibdesign\Ticket\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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
        $ticket->update(['admin_seen_at' => now()]);
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
        if ($ticket->user && $ticket->user->email){
            Mail::to($ticket->user)->queue(new TicketUpdateMail($ticket));
        }
        return $ticket->responded();
    }
}
