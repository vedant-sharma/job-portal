<?php

namespace App\Observers;

use App\Models\AppliedJob;
use App\Models\Job;

class JobObserver
{
    public function deleted(Job $job)
    {
        $job->applications()->delete();
        return $job;      
    }
}
