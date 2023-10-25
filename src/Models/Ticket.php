<?php

namespace Fibdesign\Ticket\Models;

use App\Models\User;
use Fibdesign\Ticket\observers\TicketObserver;
use Fibdesign\Ticket\traits\HasInteractsWithTickets;
use Fibdesign\Ticket\traits\HasScopes;
use Fibdesign\Toolkit\Traits\HasCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Ticket extends Model
{
    use SoftDeletes,
        HasScopes,
        HasInteractsWithTickets,
        HasCategory;
    protected $guarded = [];

    protected static function booted()
    {
        static::addGlobalScope('trashed', function (Builder $builder) {
            $builder->withTrashed();
        });
        Ticket::observe(TicketObserver::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function assignedToUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
    public function messages(): HasMany
    {
        return $this->hasMany(TicketMessage::class);
    }
}
