<?php

namespace Signifly\Responder\Support;

use Illuminate\Http\Resources\Json\JsonResource;

class ResourceFactory
{
    public function make(string $model): JsonResource
    {
        $resourceClass = ResourceResolver::forModel($model);

        return new $resourceClass();
    }

    public static function forModel(string $model): JsonResource
    {
        return (new self())->make($model);
    }
}
