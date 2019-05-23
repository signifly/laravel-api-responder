<?php

namespace Signifly\Responder\Support;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Illuminate\Database\Eloquent\Model;
use Signifly\Responder\Contracts\ModelResolver as Contract;

class ModelResolver implements Contract
{
    public function resolve($data, string $type): string
    {
        $methodName = 'resolveFor'.Str::studly($this->type);
        if (method_exists($this, $methodName)) {
            return $this->$methodName($data);
        }

        throw new InvalidArgumentException(
            sprintf('The type `%s` is invalid for resolving a model.', $this->type)
        );
    }

    protected function guardAgainstInvalidItem($item): void
    {
        if (! $item instanceof Model) {
            throw new Exception('The collection should consists of models.');
        }
    }

    protected function resolveForArray($data): string
    {
        if (empty($data)) {
            return null;
        }

        $item = Arr::first($data);

        return $this->resolveItem($item);
    }

    protected function resolveForCollection($data): string
    {
        if ($data->isEmpty()) {
            return null;
        }

        $item = $data->first();

        return $this->resolveItem($item);
    }

    protected function resolveForPaginator($data): string
    {
        if ($data->isEmpty()) {
            return null;
        }

        $item = $data->items()->first();

        return $this->resolveItem($item);
    }

    protected function resolveItem($item): string
    {
        $this->guardAgainstInvalidItem($item);

        return get_class($item);
    }
}
