<?php

namespace App\Policies;

use App\Models\JobSeeker;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class JobSeekerPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return true; // Allow all users to create a job seeker profile
    }

    public function update(User $user, JobSeeker $jobSeeker)
    {
        return $user->id === $jobSeeker->user_id;
    }

    public function delete(User $user, JobSeeker $jobSeeker)
    {
        return $user->id === $jobSeeker->user_id;
    }
}