<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\PaymentDriver;

class PaymentDriverPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, PaymentDriver $paymentDriver): bool
    {
        return $user->isAdmin || $user->id === $paymentDriver->user_id;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin;
    }

    public function update(User $user, PaymentDriver $paymentDriver): bool
    {
        return $user->isAdmin;
    }

    public function delete(User $user, PaymentDriver $paymentDriver): bool
    {
        return $user->isAdmin;
    }

    public function restore(User $user, PaymentDriver $paymentDriver): bool
    {
        return $user->isAdmin;
    }

    public function forceDelete(User $user, PaymentDriver $paymentDriver): bool
    {
        return $user->isAdmin;
    }
}
