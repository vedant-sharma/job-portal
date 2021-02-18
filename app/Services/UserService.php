<?php

namespace App\Services;

use App\Models\Job;
use Illuminate\Http\Request;
use App\Repositories\Contracts\UserRepository;

class UserService 
{
    protected $jobs;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function getUsersByJob($id)
    {
        return $this->users->getUsersByJob($id);

       // return $job->userapplications()->paginate(10); 
    }
}
