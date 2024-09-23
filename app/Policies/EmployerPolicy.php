<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Employer;

class EmployerPolicy
{
    public function viewAny(User $user)
    {
        return true; // Anyone can view the list of employers
    }

    public function view(User $user, Employer $employer)
    {
        return true; // Anyone can view a employer's details
    }

    public function create(User $user)
    {
        return true; // Any authenticated user can create a employer
    }

    public function update(User $user, Employer $employer)
    {
        return $user->id === $employer->user_id;
    }

    public function delete(User $user, Employer $employer)
    {
        return $user->id === $employer->user_id;
    }

    public function restore(User $user, Employer $employer)
    {
        return $user->id === $employer->user_id;
    }

    public function forceDelete(User $user, Employer $employer)
    {
        return $user->id === $employer->user_id;
    }
}