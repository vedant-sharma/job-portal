<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class JobApplicationNotifyRecruiter extends Mailable
{
    use Queueable, SerializesModels;

    public $jobs,$users;

    /**
     * Create a new message instance

     *
     * @return void
     */
    public function __construct($jobs,$users)
    {
        $this->jobs = $jobs;
        $this->users = $users;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.jobNotifyRecruiter')->with('jobs',$this->jobs)->with('users',$this->users);
    }
}
