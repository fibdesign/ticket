<?php

namespace Fibdesign\Ticket\traits;

use Fibdesign\Ticket\enums\StatusEnums;
use Illuminate\Database\Eloquent\Model;
use function PHPUnit\Framework\isEmpty;

trait HasInteractsWithTickets
{
    public function archive(): self
    {
        $this->delete();
        return $this;
    }
    public function unArchive(): self
    {
        $this->restore();
        return $this;
    }
    public function close(): self
    {
        $this->update([
            'status' => StatusEnums::CLOSED,
        ]);

        return $this;
    }
    public function responded(): self
    {
        $this->update([
            'status' => StatusEnums::RESPONDED,
        ]);

        return $this;
    }
    public function userResponded(): self
    {
        $this->update([
            'status' => StatusEnums::WAITING,
        ]);

        return $this;
    }
    public function open(): self
    {
        $this->update([
            'status' => StatusEnums::OPEN,
        ]);

        return $this;
    }
    public function resolve(): self
    {
        $this->update([
            'is_resolved' => true,
        ]);

        return $this;
    }
    public function lock(): self
    {
        $this->update([
            'is_locked' => true,
        ]);

        return $this;
    }
    public function seen(): self
    {
        $this->update([
            'seen_at' => now(),
        ]);

        return $this;
    }
    public function unlock(): self
    {
        $this->update([
            'is_locked' => false,
        ]);

        return $this;
    }
    public function assignTo(Model|int $user): self
    {
        $this->update([
            'assigned_to' => $user,
        ]);

        return $this;
    }

    public function isArchived(): bool
    {
        return !isEmpty($this->deleted_at);
    }
    public function isOpen(): bool
    {
        return $this->status == StatusEnums::OPEN;
    }
    public function isClosed(): bool
    {
        return ! $this->isOpen();
    }
    public function isResolved(): bool
    {
        return $this->is_resolved;
    }
    public function isUnresolved(): bool
    {
        return ! $this->isResolved();
    }
    public function isLocked(): bool
    {
        return $this->is_locked;
    }
    public function isUnlocked(): bool
    {
        return ! $this->isLocked();
    }
}
