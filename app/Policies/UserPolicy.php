<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function create(User $user)
    {
        return false;
    }
    public function view(User $user)
    {
        return true;
    }
    public function delete(User $user)
    {
        // if($user->role_id == 1)
        // return false;
        // else
        // return true;

        return $user->role_id == 1;
    }

    public function attachTag(User $user, Podcast $podcast, Tag $tag)
    {
        return $user->role_id === 2;
    }
}
