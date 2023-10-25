<?php

namespace Fibdesign\Ticket\traits;

use Fibdesign\Ticket\enums\PrioritiesEnums;
use Fibdesign\Ticket\enums\StatusEnums;

use Illuminate\Database\Eloquent\Builder;

trait HasScopes
{
    public function scopeClosed(Builder $builder): Builder
    {
        return $builder->where('status', StatusEnums::CLOSED);
    }
    public function scopeOpened(Builder $builder): Builder
    {
        return $builder->where('status', StatusEnums::OPEN);
    }
    public function scopeResolved(Builder $builder): Builder
    {
        return $builder->where('is_resolved', true);
    }
    public function scopeUnresolved(Builder $builder): Builder
    {
        return $builder->where('is_resolved', false);
    }
    public function scopeLocked(Builder $builder): Builder
    {
        return $builder->where('is_locked', true);
    }
    public function scopeUnlocked(Builder $builder): Builder
    {
        return $builder->where('is_locked', false);
    }
    public function scopeWithPriority(Builder $builder, string $priority): Builder
    {
        return $builder->where('priority', $priority);
    }
    public function scopeWithLowPriority(Builder $builder): Builder
    {
        return $builder->where('priority', PrioritiesEnums::LOW);
    }
    public function scopeWithNormalPriority(Builder $builder): Builder
    {
        return $builder->where('priority', PrioritiesEnums::NORMAL);
    }
    public function scopeWithHighPriority(Builder $builder): Builder
    {
        return $builder->where('priority', PrioritiesEnums::HIGH);
    }
    public function scopeArchived(Builder $builder): Builder
    {
        return $builder->whereNotNull('deleted_at');
    }
    public function scopeUnArchived(Builder $builder): Builder
    {
        return $builder->whereNull('deleted_at');
    }
}
