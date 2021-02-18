<?php

namespace App\Http\Controllers\Api\v1;

use JWTAuth;
use App\Models\Otp;
use App\Models\User;
use App\Mail\OtpVerify;
use App\Services\AuthService;
use Spatie\Fractalistic\Fractal;
use App\Jobs\EmailForgotPassword;
use Illuminate\Support\Facades\Auth;
use App\Transformers\UserTransformer;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    /**
     * @var AuthService
     */
    protected $auths;

    /**
     * @param AuthService $auth
     */

    public function __construct(AuthService $auths)
    {
        $this->auths = $auths;
    }

    public function login()
    {
        $inputs = request()->all();
        $user = $this->auths->login($inputs);

        return response()->success(
            $this->getTransformedData($user, new UserTransformer)
        );
    }

    public function register()
    {
        $inputs = request()->all();
        $user =  $this->auths->register($inputs);
        
        return response()->success(
            $this->getTransformedData($user, new UserTransformer)
        );
    }

    public function forgotpassword()
    {
        $inputs = request()->all();
        $this->auths->forgotpassword($inputs);
        return response()->success('OTP sent on your mail');
    }

    public function resetPassword()                   
    {
        $inputs = request()->all();
        $this->auths->resetPassword($inputs);
        return response()->success('Password reset successful');

    }
}