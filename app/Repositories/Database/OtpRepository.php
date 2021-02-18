<?php

namespace App\Repositories\Database;

use App\Models\Otp;
use App\Traits\DatabaseTrait;
use App\Repositories\Contracts\OtpRepository as OtpRepositoryContract;

class OtpRepository implements OtpRepositoryContract
{
    use DatabaseTrait;

    private $model = Otp::class;

}

