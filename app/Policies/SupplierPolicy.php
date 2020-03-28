<?php

namespace App\Policies;

use App\Supplier;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SupplierPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any suppliers.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the supplier.
     *
     * @param  \App\User  $user
     * @param  \App\Supplier  $supplier
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->hasAnyRoles(['ADMIN', 'CLIENT']);
    }

    /**
     * Determine whether the user can create suppliers.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasRole('ADMIN');
    }

    /**
     * Determine whether the user can update the supplier.
     *
     * @param  \App\User  $user
     * @param  \App\Supplier  $supplier
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->hasRole('ADMIN');
    }

    /**
     * Determine whether the user can delete the supplier.
     *
     * @param  \App\User  $user
     * @param  \App\Supplier  $supplier
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->hasRole('ADMIN');
    }

    /**
     * Determine whether the user can restore the supplier.
     *
     * @param  \App\User  $user
     * @param  \App\Supplier  $supplier
     * @return mixed
     */
    public function restore(User $user, Supplier $supplier)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the supplier.
     *
     * @param  \App\User  $user
     * @param  \App\Supplier  $supplier
     * @return mixed
     */
    public function forceDelete(User $user, Supplier $supplier)
    {
        //
    }
}
