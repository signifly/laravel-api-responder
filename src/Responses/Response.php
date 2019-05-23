<?php

namespace Signifly\Responder\Responses;

use Illuminate\Contracts\Support\Responsable;

abstract class Response implements Responsable
{
    /**
     * Get the http resource class for a given model.
     *
     * @param  string $model
     * @return string
     */
    protected function getResourceClassFor(string $model)
    {
        $resourceClass = ResourceResolver::forModel($model);

        if (config('responder.force_resources') && ! class_exists($resourceClass)) {
            throw new Exception(sprintf('Could not find a resource for %s', $model));
        }

        return $resourceClass;
    }
}
