<?php

namespace App\Repositories\Contracts;

interface JobRepository extends Repository
{
    public function search(array $inputs);

    public function applied(array $inputs); 
}