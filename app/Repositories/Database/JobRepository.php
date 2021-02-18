<?php

namespace App\Repositories\Database;

use App\Models\Job;
use App\Traits\DatabaseTrait;
use Illuminate\Support\Facades\DB;
use App\Exceptions\ModelNotFoundException;
use App\Repositories\Contracts\JobRepository as JobRepositoryContract;

class JobRepository implements JobRepositoryContract
{
    use DatabaseTrait;

    private $model = Job::class;

    public function applied(array $inputs)
    {
        $query = $this->query();
        $candidate_id = array_get($inputs, 'candidate_id');

        $query->whereHas('applications', function($q) use($candidate_id) {
            $q->where('applied_jobs.user_id', $candidate_id);
        });

        logger($query->toSql());

        return $query->paginate(10);
    }


    public function search(array $inputs) // candidate available jobs and recruiter posted jobs
    {
        $query = $this->query();

        $recruiter_id = array_get($inputs, 'recruiter_id');

        if ($recruiter_id) {
            $query->where('user_id', $recruiter_id);
        }

        $user_id = array_get($inputs, 'candidate_id');
        
        if ($user_id && array_get($inputs, 'except_applied_jobs')) {
            $query->whereDoesntHave('applications', function($q) use($user_id) {
                $q->where('applied_jobs.user_id', $user_id);
            });
        }

        logger($query->toSql());

        return $query->paginate(10);
    }
}