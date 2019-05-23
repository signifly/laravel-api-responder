<?php

namespace Signifly\Responder\Support;

class ResourceResolver
{
    /** @var string */
    protected $model;

    public function __construct(string $model)
    {
        $this->model = $model;
    }

    public static function forModel(string $model): string
    {
        return (new self($model))->handle();
    }

    public function handle(): string
    {
        $modelName = class_basename($this->model);

        $resourceName = config('responder.namespace').'\\'.$modelName;

        return config('responder.use_type_suffix')
            ? $resourceName
            : $resourceName.'Resource';
    }
}
