<?php

namespace App\Services;

use JWTAuth;
use App\Models\Otp;
use App\Validators\AuthValidator;
use App\Jobs\EmailForgotPassword;
use Illuminate\Support\Facades\Auth;
use App\Transformers\UserTransformer;
use App\Exceptions\InvalidOtpException;
use App\Exceptions\OtpExpiredException;
use App\Exceptions\InvalidEmailException;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Providers\ValidationServiceProvider;
use App\Repositories\Contracts\OtpRepository;
use App\Exceptions\InvalidCredentialException;
use App\Repositories\Contracts\UserRepository;

class AuthService
{
    /**
     * @var OtpRepository
     */
    protected $otps;
    protected $users;
    protected $validator;

    /**
     * @param OtpRepository $otps
     */
    public function __construct(OtpRepository $otps, UserRepository $users, AuthValidator $validator)
    {
        $this->otps = $otps;
        $this->users = $users;
        $this->validator = $validator;
    }

    public function resetPassword($inputs)
    {
        $this->validator->fire($inputs, 'resetpassword');
       
        $otp = $this->otps->firstWhere('otp', $inputs['otp'], [  // Check whether otp is valid
            'is_active' => true,
        ],false);

        if(!$otp)
            $this->throwInvalidOtpException();
        
        if($otp->has_expired)
            $this->throwOtpExpiredException();

        $this->users->updateWhere('id', $otp->user_id, [     //update the password in users table
            'password' => bcrypt($inputs['new_password']),
        ]);

        $this->otps->updateWhere('id', $otp->id, [          //set is_active to false in otp table
            'is_active' => false,
        ]);

        return true;
    }

    public function forgotPassword($inputs)
    {
        $this->validator->fire($inputs, 'forgotpassword');

        $user = $this->users->firstWhere('email', $inputs['email'],null,false);

        if(!$user)
            return $this->throwInvalidEmailException();

        $otp = generate_otp();

        $objotp = array("user_id"=>$user->id, "otp"=>$otp, "is_active"=>true);
        $this->otps->create($objotp);

        dispatch(new EmailForgotPassword($inputs['email'],$otp));

        return true;
    }

    public function register($inputs)
    {
        
        $this->validator->fire($inputs, 'register');
        
        $inputs['uuid'] = generate_uuid();
        $inputs['password'] = bcrypt($inputs['password']);
        $inputs['email'] = strtolower($inputs['email']);

        $u = $this->users->create($inputs);

        $u['token'] = JWTAuth::fromUser($u);
        return $u;

    }

    public function login($inputs)
    {
        
        $this->validator->fire($inputs, 'login');

        if($token = Auth::attempt($inputs)){
            $u = $this->users->firstWhere('email',$inputs['email'],null,false);
            $u['token'] = JWTAuth::fromUser($u);
            return $u; 
        }

        else
            $this->throwInvalidCredentialException();
    
    }

    //Exceptions

    private function throwInvalidCredentialException() 
    {
        throw new InvalidCredentialException( "Invalid Credentials" );
    }

    private function throwOtpExpiredException() 
    {
        throw new OtpExpiredException( "You OTP has expired" );
    } 

    private function throwInvalidOtpException() 
    {
        throw new InvalidOtpException( "Invalid OTP" );
    } 

    private function throwInvalidEmailException() 
    {
        throw new InvalidOtpException( "This email is not registered." );
    } 

}