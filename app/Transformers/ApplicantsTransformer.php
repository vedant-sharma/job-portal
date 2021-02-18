<?php

namespace App\Transformers;

use App\Models\User;
use League\Fractal;

class ApplicantsTransformer extends Fractal\TransformerAbstract
{
	public function transform(User $user)
	{
        return [
            'first_name'    => (string) $user->first_name,
            'last_name'     => (string) $user->last_name,
            'email'         => (string) $user->email,
            'phone'         => (string) $user->phone,
        ];
	}
}