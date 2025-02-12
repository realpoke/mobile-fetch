<?php

namespace App\Models;

use App\Enums\ItemStatusEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Item extends Model
{
    public function casts(): array
    {
        return [
            'status' => ItemStatusEnum::class,
        ];
    }

    public function fetch(): BelongsTo
    {
        return $this->belongsTo(Fetch::class);
    }

    public function scopeSearch(Builder $query, string $name): Builder
    {
        return $query->where('name', 'like', '%'.$name.'%');
    }

    public function scopeNotDone(Builder $query): Builder
    {
        return $query->whereIn('status', ItemStatusEnum::notDoneStatues());
    }

    public function scopeDone(Builder $query): Builder
    {
        return $query->whereIn('status', ItemStatusEnum::doneStatues());
    }
}
