<?php

namespace App\Repositories\Database;

use App\Models\AppliedJob;
use App\Traits\DatabaseTrait;
use App\Repositories\Contracts\AppliedJobRepository as AppliedJobRepositoryContract;

class AppliedJobRepository implements AppliedJobRepositoryContract
{
    use DatabaseTrait;

    private $model = AppliedJob::class;

    public function getAppliedJob($user)
    {
        return AppliedJob::where('user_id', $user->id)->get();
    }

}