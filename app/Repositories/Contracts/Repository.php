<?php

namespace App\Repositories\Contracts;

interface Repository
{
    public function firstWhere($column, $value, $moreWhere);

    public function updateWhere($column, $value, $inputs);

    public function create($data);

    public function getData();

    public function query();
}