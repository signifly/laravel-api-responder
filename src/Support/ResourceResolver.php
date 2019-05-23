<?php

namespace Signifly\Responder\Support;

use Signifly\Responder\Exceptions\ResourceNotFoundException;
use Signifly\Responder\Contracts\ResourceResolver as Contract;

class ResourceResolver implements Contract
{
    /**
     * Resolve a resource from a model class.
     *
     * @param  string $model
     * @return string|null
     */
    public function resolve(?string $model): ?string
    {
        if (empty($model)) {
            return null;
        }

        $modelName = class_basename($model);

        $resourceName = config('responder.namespace').'\\'.$modelName;

        $resourceClass = config('responder.use_type_suffix')
            ? $resourceName.'Resource'
            : $resourceName;

        if (! class_exists($resourceClass) && config('responder.force_resources')) {
            throw ResourceNotFoundException::for($resourceClass);
        }

        return class_exists($resourceClass) ? $resourceClass : null;
    }
}
