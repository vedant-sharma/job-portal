<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class JobPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    public function create()
    {
            return false;
    }

    public function delete()
    {
        return true;
    }

    public function attachTag(User $user, Podcast $podcast, Tag $tag)
    {
        return $user->role_id === 2;
    }
}
