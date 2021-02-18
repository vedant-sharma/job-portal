<?php

namespace App\Transformers;

use App\Models\User;
use League\Fractal;

class UserTransformer extends Fractal\TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'first_name'    => (string) $user->first_name,
            'last_name'     => (string) $user->last_name,
            'role_id'       => (string) $user->role_id,
            'email'         => (string) $user->email,
            'phone'         => (string) $user->phone,
            'uuid'          => (string) $user->uuid,
            'token'         => (string) $user->token,
        ];
    }
}
