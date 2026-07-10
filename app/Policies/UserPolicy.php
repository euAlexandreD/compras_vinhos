<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct() {}

    public function listUsers(User $user)
    {
        return $this->isAdmin($user);
    }

    public function addNewWine(User $user)
    {
        return $this->isAdmin($user);
    }

    public function viewOrders(User $user)
    {
        return $this->isAdmin($user);
    }

    public function editWine(User $user)
    {
        return $this->isAdmin($user);
    }

    /**
     * Assigning roles grants privileges (including Admin), so it stays a
     * separate ability from listUsers instead of piggybacking on it.
     */
    public function manageRoles(User $user)
    {
        return $this->isAdmin($user);
    }

    /**
     * A user may update their own profile; only an Admin may update someone else's.
     */
    public function updateProfile(User $user, User $model)
    {
        return $user->id === $model->id || $this->isAdmin($user);
    }

    private function isAdmin(User $user): bool
    {
        return $user->roles()
            ->where('name', 'Admin')
            ->exists();
    }
}
