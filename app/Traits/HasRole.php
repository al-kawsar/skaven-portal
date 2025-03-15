<?php

namespace App\Traits;

use App\Models\Role;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasRole
{
    /**
     * Get the role that belongs to the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Assign the given role to the user.
     *
     * @param  string  $role
     * @return void
     */
    public function assignRole(string $role): void
    {
        $role = Role::where('name', $role)->firstOrFail();

        $this->role()->associate($role);
        $this->save();
    }

    /**
     * Determine if the user has the given role.
     *
     * @param  string  $role
     * @return bool
     */
    public function hasRole(string $role): bool
    {
        return $this->role?->name === $role;
    }
}
