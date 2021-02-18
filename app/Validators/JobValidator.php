<?php

namespace App\Validators;

class JobValidator extends Validator
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
            case 'postjob':
                $rules = [
                    'title' => 'required|max:255',
                    'description' => 'required|max:255',
                    'company' => 'required|max:255'
                ];
                break;
        }

        return $rules;
    }
}
