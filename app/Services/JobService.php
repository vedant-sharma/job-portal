<?php

namespace App\Services;

use App\Models\Job;
use App\Models\User;
use App\Models\AppliedJob;
use Illuminate\Http\Request;
use App\Jobs\EmailJobNotify;
use App\Validators\JobValidator;
use App\Transformers\JobTransformer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Exceptions\JobAlreadyExistsException;
use App\Repositories\Contracts\JobRepository;
use App\Exceptions\JobAlreadyAppliedException;
use App\Repositories\Contracts\UserRepository;
use App\Repositories\Contracts\AppliedJobRepository;

class JobService
{
    protected $users;
    protected $jobs;
    protected $appliedjobs;
    protected $validator;

    public function __construct(JobRepository $jobs, UserRepository $users, AppliedJobRepository $appliedjobs, JobValidator $validator)
    {
        $this->jobs = $jobs;
        $this->users = $users;
        $this->appliedjobs = $appliedjobs;
        $this->validator = $validator;
    }
    

    public function index($user) // Available job for candidate
    {
        $inputs = [
            'candidate_id' => optional($user)->id,
            'except_applied_jobs' => true,
        ];

        return $this->jobs->search($inputs);
    }

    public function apply($id)
    {
        $jobs = $this->jobs->firstWhere('uuid',$id);

        $recruiterinfo = $this->users->firstWhere('id',$jobs->user_id);

        $already_applied = $this->appliedjobs->firstWhere('job_id', $jobs->id,[
            'user_id' => auth()->user()->id
        ],false);

        if($already_applied)
            $this->throwJobAlreadyAppliedException();

        $this->appliedjobs->create(array("job_id" => $jobs->id, "user_id" => auth()->user()->id));

        //dispatch(new EmailJobNotify(auth()->user()->email,$recruiterinfo->email, $jobs, auth()->user())); //Email to recruiter and candidate

        return $jobs;
    }

    public function applied($user)
    {
        $inputs = [
            'candidate_id' => $user->id,
        ];
        return $this->jobs->applied($inputs);
    }

    // Recruiter Services

    public function postjob($job)
    {
        $this->validator->fire($job, 'postjob');

        $jobexists = $this->jobs->firstwhere('title', $job['title'],[
            'company' => $job['company']
        ],false);

        if($jobexists)
            $this->throwJobAlreadyExistsException();

        $job['uuid'] = generate_uuid();
        $job['user_id'] = auth()->user()->id;

        $created = $this->jobs->create($job);
        return $created;
    }

    public function getJobsByRecruiter(User $user)
    {
        $inputs = [
            'recruiter_id' => $user->id,
        ];

        return $this->jobs->search($inputs);
    }    

    //Exceptions

    private function throwJobAlreadyAppliedException()
    {
        throw new JobAlreadyAppliedException('You have already applied to this job');
    }

    private function throwJobAlreadyExistsException()
    {
        throw new JobAlreadyExistsException('Job with same criteria already Exists');
    }

}