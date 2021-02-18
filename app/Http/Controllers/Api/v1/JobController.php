<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Job;
use App\Models\User;
use App\Models\AppliedJob;
use App\Services\JobService;
use Illuminate\Http\Request;
use App\Jobs\EmailCandidateJob;
use App\Jobs\EmailRecruiterJob;
use Spatie\Fractalistic\Fractal;
use App\Transformers\JobTransformer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class JobController extends Controller
{
    protected $jobs;
    
    public function __construct(JobService $jobs)
    {
        $this->jobs = $jobs;
    }

    // Candidate Methods

    public function index() //available job
    {
        $jobs = $this->jobs->index(auth()->user());
   
        return response()->withMeta(
            $this->getTransformedPaginatedData($jobs, new JobTransformer)
        );
    }

    public function apply($id)
    {
        $data = $this->jobs->apply($id);
        return response()->success('You have successfully applied to this job');
    }

    public function applied()
    {
        $applied = $this->jobs->applied(auth()->user());

        return response()->withMeta(
            $this->getTransformedPaginatedData($applied, new JobTransformer)
        );
    }


    // Recruiter Methods

    public function create()
    {
        $job = request()->all();
        $createdjob = $this->jobs->postjob($job);

         return response()->success(
            $this->getTransformedData($createdjob, new JobTransformer)
        );
    }


    public function getJobsByRecruiter()
    { 
        $jobs = $this->jobs->getJobsByRecruiter(auth()->user());

        return response()->withMeta(
            $this->getTransformedPaginatedData($jobs, new JobTransformer)
        );
    }
}