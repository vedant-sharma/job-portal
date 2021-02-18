<?php

use Illuminate\Support\Str;

function generate_uuid()
{
    return Str::uuid()->toString();
}

function carbon()
{
    return app(Carbon\Carbon::class);
}

function generate_otp()
{
    $generator = "1357902468";
        $otp = "";

        for ($i = 1; $i <= 6; $i++) 
        {
            $otp .= substr($generator, (rand()%(strlen($generator))), 1); 
        } 
    
    return $otp;
}