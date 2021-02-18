<?php

namespace App\Transformers;

use App\Models\Job;
use League\Fractal;

class JobTransformer extends Fractal\TransformerAbstract
{
	public function transform(Job $job)
	{
	    return [
            'uuid'          => (string) $job->uuid,
            'title'         => (string) $job->title,
            'desciption'    => (string) $job->description,
            'company'       => (string) $job->company,
        ];
	}
}