<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Context;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use BelongsToUser, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected $attributes = [
        'password' => 'bcrypt(\'default_password\')',
    ];

    public function getAllPermissions()
    {
        if (Auth::user()->id === $this->id && Context::hasHidden('permissions')) {
            return Context::getHidden('permissions');
        }

        $groupPermissions = $this
            ->roles()
            ->with('permissions')
            ->get()
            ->pluck('permissions')
            ->flatten()
            ->pluck('name');

        $permissions = collect($this->permissions);

        return $groupPermissions->merge($permissions)->unique()->map(function ($item) {
            return strtolower($item);
        });
    }

    public function hasRole($role): bool
    {
        if (Context::hasHidden('roles')) {
            return in_array(strtolower($role), Context::getHidden('roles'));
        }

        return $this->roles()->withoutGlobalScopes()->where('name', $role)->exists();
    }

    public function hasPermission($permission): bool
    {
        if ($permission instanceof \BackedEnum) {
            $permission = $permission->value;
        }

        return $this->getAllPermissions()->contains(strtolower($permission));
    }

    public function hasAnyPermission(array $permissions): bool
    {
        $perms = array_map(function ($value) {
            if ($value instanceof \BackedEnum) {
                $value = $value->value;
            }

            return strtolower($value);
        }, $permissions);

        return $this->getAllPermissions()->intersect($perms)->isNotEmpty();
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }
}
