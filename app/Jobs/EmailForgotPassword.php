<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Mail\OtpVerify;
use Mail;

class EmailForgotPassword implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $emailto;
    public $otptosend; 

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email,$otp)
    {
         $this->emailto = $email;
         $this->otptosend = $otp;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->emailto)->queue(new OtpVerify($this->otptosend));
    }
}
