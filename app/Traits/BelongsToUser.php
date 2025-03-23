<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

trait BelongsToUser
{
    protected static function bootBelongsToUser(): void
    {
        static::creating(function ($model) {
            $model->created_by = Auth::id();
        });
    }

    public function owner(Model $model): bool
    {
        return $this->id === $model->created_by;
    }

    public function notOwner(Model $model): bool
    {
        return $this->id !== $model->created_by;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by')->withDefault([
            'name' => 'System generated',
        ]);
    }
}
