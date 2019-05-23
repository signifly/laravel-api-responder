<?php

namespace Signifly\Responder\Support;

use Signifly\Responder\Contracts\ResourceResolver as Contract;

class ResourceResolver implements Contract
{
    public function resolve(string $model): ?string
    {
        if (empty($model)) {
            return null;
        }

        $modelName = class_basename($model);

        $resourceName = config('responder.namespace').'\\'.$modelName;

        $resourceClass = config('responder.use_type_suffix')
            ? $resourceName
            : $resourceName.'Resource';

        if (! class_exists($resourceClass) && config('responder.force_resources')) {
            throw ResourceNotFoundException::for($resourceClass);
        }

        return $resourceClass;
    }
}
