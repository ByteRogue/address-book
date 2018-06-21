<?php

namespace App\Policies;

use App\User;
use App\Agency;
use Illuminate\Auth\Access\HandlesAuthorization;

class AgencyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the agency.
     *
     * @param  \App\User  $user
     * @param  \App\Agency  $agency
     * @return mixed
     */
    public function view(User $user, Agency $agency)
    {
      return $user->role == 'admin';
    }

    /**
     * Determine whether the user can create agencies.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
      return $user->role == 'admin';
    }

    /**
     * Determine whether the user can update the agency.
     *
     * @param  \App\User  $user
     * @param  \App\Agency  $agency
     * @return mixed
     */
    public function update(User $user, Agency $agency)
    {
        //
      return $user->role == 'admin';
    }

    /**
     * Determine whether the user can delete the agency.
     *
     * @param  \App\User  $user
     * @param  \App\Agency  $agency
     * @return mixed
     */
    public function delete(User $user, Agency $agency)
    {
        //
      return $user->role == 'admin';
    }
}
