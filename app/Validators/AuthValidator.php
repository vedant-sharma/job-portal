<?php

namespace App\Validators;

class AuthValidator extends Validator
{
    /**
    * Validation rules.
    *
    * @param  string $type
    * @param  array $data
    * @return array
    */

    protected function rules($data, $type)
    {
        $rules = [];

        switch($type)
        {
            case 'login':
                $rules = [
                    'email' => 'required|email|max:255',
                    'password' => 'required|max:255|min:6'
                ];
                break;

            case 'register':
                $rules = [
                    'first_name' => 'required|string|max:255',
                    'last_name' => 'required|string|max:255',
                    'phone' => 'required|phones',
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required|max:255|min:6',
                    'role_id' => 'required|min:2|max:3|integer'
                ];
                break;

            case 'forgotpassword':
                $rules = [
                    'email' => 'required|email|max:255'
                ];
                break;

            case 'resetpassword':
                $rules = [
                    'otp' => 'required|numeric|otp',
                    'new_password' => 'required|max:255|min:6'
                ];
        }

        return $rules;
    }
}
