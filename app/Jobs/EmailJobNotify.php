<?php

namespace App\Jobs;

use Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\JobApplicationNotifyCandidate;
use App\Mail\JobApplicationNotifyRecruiter;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class EmailJobNotify implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $candidate_email;
    public $recruiter_email;
    public $jobdata;
    public $candidatedata;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($candidate_email, $recruiter_email, $job, $user)
    {
        $this->candidate_email = $candidate_email;
        $this->recruiter_email = $recruiter_email;
        $this->jobdata = $job;
        $this->candidatedata = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->recruiter_email)->queue(new JobApplicationNotifyRecruiter($this->jobdata,$this->candidatedata));

        Mail::to($this->candidate_email)->queue(new JobApplicationNotifyCandidate($this->jobdata));
    }
}
