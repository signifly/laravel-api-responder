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
        $baseClass = class_basename($model);
        $class = config('responder.namespace').'\\'.$baseClass;

        if (config('responder.force_resources') && ! class_exists($class)) {
            throw new Exception(sprintf('Could not find a resource for %s', $baseClass));
        }

        return $class;
    }
}
