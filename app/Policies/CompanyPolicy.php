<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Company;

class CompanyPolicy
{
    public function viewAny(User $user)
    {
        return true; // Anyone can view the list of companies
    }

    public function view(User $user, Company $company)
    {
        return true; // Anyone can view a company's details
    }

    public function create(User $user)
    {
        return true; // Any authenticated user can create a company
    }

    public function update(User $user, Company $company)
    {
        return $user->id === $company->user_id;
    }

    public function delete(User $user, Company $company)
    {
        return $user->id === $company->user_id;
    }

    public function restore(User $user, Company $company)
    {
        return $user->id === $company->user_id;
    }

    public function forceDelete(User $user, Company $company)
    {
        return $user->id === $company->user_id;
    }
}