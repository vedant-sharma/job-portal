<?php

namespace App\Traits;

use App\Exceptions\ModelNotFoundException;

trait DatabaseTrait
{
    public function firstWhere($column, $value, $moreWhere=null, $throw=true)
    {
        $query = $this->query();

        $query->where($column, $value);

        if ($moreWhere) {
            $query->where($moreWhere);
        }

        $model = $query->first();

        if (!$model && $throw) {
            $this->throwModelNotFoundException();
        }

        return $model;
    }

    public function updateWhere($column, $value, $inputs)
    {
        $query = $this->query();

        $query->where($column, $value);

        return $query->update($inputs);
    }

    public function create($data)
    {
        $query = $this->query();

        return $query->create($data);
    }

    public function getData($throw = true)
    {
        $model = $this->query();

        if(!$model && $throw)
        {
            $this->throwModelNotFoundException();
        }

        return $model;
    }

    private function throwModelNotFoundException()
    {
        throw new ModelNotFoundException( "No record found." );
    }

    public function query()
    {
        return call_user_func("$this->model::query");
    }
}