<?php

namespace App\Transformers\Serializers;

use League\Fractal\Serializer\ArraySerializer;

class CustomArraySerializer extends ArraySerializer
{
    public function collection($resourceKey, array $data)
    {
        return $data;
    }
}
