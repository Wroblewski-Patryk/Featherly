<?php

namespace App\Policies;

use App\Models\User;

class ContentPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('manage-content');
    }

    public function view(User $user): bool
    {
        return $user->can('manage-content');
    }

    public function create(User $user): bool
    {
        return $user->can('manage-content');
    }

    public function update(User $user): bool
    {
        return $user->can('manage-content');
    }

    public function delete(User $user): bool
    {
        return $user->can('manage-content');
    }
}
