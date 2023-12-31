<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Fibdesign\Ticket\enums\StatusEnums;
use Fibdesign\Ticket\Models\Ticket;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public User $user;
    public function __construct()
    {
        $this->user = auth('sanctum')->user();
    }

    public function index(Request $request)
    {
        $queries = $request->validate([
            'status' => 'nullable',
            'archived' => 'nullable|bool',
            'assigned' => 'nullable',
            'user_id' => 'nullable'
        ]);
        $status = match ($queries['status']){
            default => StatusEnums::OPEN,
            'closed' => StatusEnums::CLOSED,
            'responded' => StatusEnums::RESPONDED,
            'waiting' => StatusEnums::WAITING
        };
        return Ticket::query()
            ->latest()
            ->where('status', $status)
            ->when($queries['user_id'], function (Builder $query) use ($queries) {
                $query->where('user_id', $queries['user_id']);
            })
            ->where('deleted_at', $queries['archived'])
            ->when($queries['assigned'], function (Builder $query) {
                $query->where('assigned_to', );
            })
            ->paginate(20);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'subject' => 'required',
            'priority' => 'required',
            'category_id' => 'nullable',
            'user_id' => 'nullable',
            'assigned_to' => 'nullable'
        ]);
        $validatedData['assigned_to'] = $this->user;
        return Ticket::create($validatedData);
    }

    public function show($ticket): Ticket
    {
        return Ticket::find($ticket);
    }

    public function update(Request $request,$ticket)
    {
        $ticket = Ticket::find($ticket);
        $data = $request->validate([
            'type' => 'required',
            'user' => 'nullable'
        ]);
        match ($data['type']){
            'open' => $ticket->open(),
            'close' => $ticket->close(),
            'assign' => $ticket->assignTo($data['user']),
            'seen' => $ticket->seen(),
        };

        return $ticket;
    }

    public function destroy($ticket): bool
    {
        $ticket = Ticket::find($ticket);
        if ($ticket->isArchived()){
            $ticket->unArchive();
        }else{
            $ticket->archive();
        }
        return $ticket->save();
    }

}
