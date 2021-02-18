<?php

namespace App\Observers;

use App\Models\Job;
use App\Models\User;

class UserObserver
{
   
    public function deleted(User $user)
    {

        if($user->role_id == config('settings.roles.recruiter'))
        {
            $user->posted_jobs()->delete();
        }

        if($user->role_id == config('settings.roles.candidate'))
        {
            $user->applied_jobs()->delete();
        }

        return $user;
            
    }

     /**
     * Handle the user "deleting" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function deleting(User $user)
    {
        $role = $user->role_id;
    }


    /**
     * Handle the user "restored" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the user "force deleted" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    
    public function forceDeleted(User $user)
    {
        //
    }
}
