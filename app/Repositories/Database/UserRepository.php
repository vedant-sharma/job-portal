<?php

namespace App\Repositories\Database;

use App\Models\User;
use App\Traits\DatabaseTrait;
use App\Repositories\Contracts\UserRepository as UserRepositoryContract;

class UserRepository implements UserRepositoryContract
{
    use DatabaseTrait;

    private $model = User::class;

    public function getUsersByJob($id)
    {
        $query = $this->query();

        $query->whereHas('applied_jobs', function($q) use($id) {
            $q->where('jobs.uuid', $id);
        });

        logger($query->toSql());

        return $query->paginate();
    }
    
} 