<?php

namespace App\Repositories\Contracts;

interface AppliedJobRepository extends Repository
{
    public function getAppliedJob($user);
}