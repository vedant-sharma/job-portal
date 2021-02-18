<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getTransformedCollectionData($collection, $transformer)
    {
        return fractal()
            ->collection($collection)
            ->transformWith($transformer)
            ->toArray();
    }

    public function getTransformedData($data, $transformer)
    {
        return fractal($data, $transformer)
            ->toArray();
    }

    public function getTransformedPaginatedData($paginatedObject, $transformer)
    {
        $collection = $paginatedObject->getCollection();

        return fractal()
            ->collection($collection, $transformer)
            ->paginateWith(new \League\Fractal\Pagination\IlluminatePaginatorAdapter($paginatedObject))
            ->toArray();
    }
}
