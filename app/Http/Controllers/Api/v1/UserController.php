<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserService;
use Spatie\Fractalistic\Fractal;
use App\Transformers\JobTransformer;
use Illuminate\Support\Facades\Auth;
use App\Transformers\ApplicantsTransformer;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    protected $userService;
    
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }


    public function getUsersByJob($id)
    {
        $applicants = $this->userService->getUsersByJob($id);
    
        return response()->withMeta(
            $this->getTransformedPaginatedData($applicants, new ApplicantsTransformer)
        );
    }
}