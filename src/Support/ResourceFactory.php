<?php

namespace Signifly\Responder\Support;

use Illuminate\Http\Resources\Json\JsonResource;

class ResourceFactory
{
    /** @var string */
    protected $model;

    public function __construct(string $model)
    {
        $this->model = $model;
    }

    public function make(): JsonResource
    {
        $resourceClass = ResourceResolver::forModel($this->model);

        return new $resourceClass();
    }

    public static function forModel(string $model): JsonResource
    {
        return (new self($model))->make();
    }
}
