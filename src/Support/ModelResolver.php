<?php

namespace Signifly\Responder\Support;

use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Signifly\Responder\Contracts\ModelResolver as Contract;

class ModelResolver implements Contract
{
    /**
     * Resolve the model from data for a given type.
     *
     * @param  mixed $data
     * @param  string $type
     * @return string|null
     */
    public function resolve($data, string $type): ?string
    {
        $methodName = 'resolveFor'.Str::studly($type);
        if (method_exists($this, $methodName)) {
            return $this->$methodName($data);
        }

        throw new InvalidArgumentException(
            sprintf('The type `%s` is invalid for resolving a model.', $type)
        );
    }

    /**
     * Guard against invalid item.
     *
     * @param  mixed $item
     * @return void
     */
    protected function guardAgainstInvalidItem($item): void
    {
        if (! $item instanceof Model) {
            throw new Exception('The collection should consists of models.');
        }
    }

    /**
     * Resolve for an array.
     *
     * @param  array  $data
     * @return string|null
     */
    protected function resolveForArray(array $data): ?string
    {
        if (empty($data)) {
            return null;
        }

        $item = Arr::first($data);

        return $this->resolveItem($item);
    }

    /**
     * Resolve for a collection.
     *
     * @param  \Illuminate\Support\Collection $data
     * @return string|null
     */
    protected function resolveForCollection(Collection $data): ?string
    {
        if ($data->isEmpty()) {
            return null;
        }

        $item = $data->first();

        return $this->resolveItem($item);
    }

    /**
     * Resolve for paginator.
     *
     * @param  \Illuminate\Contracts\Pagination\LengthAwarePaginator $data
     * @return string|null
     */
    protected function resolveForPaginator(LengthAwarePaginator $data): ?string
    {
        if ($data->isEmpty()) {
            return null;
        }

        $item = $data->getCollection()->first();

        return $this->resolveItem($item);
    }

    /**
     * Resolve an item.
     *
     * @param  mixed $item
     * @return string
     */
    protected function resolveItem($item): string
    {
        $this->guardAgainstInvalidItem($item);

        return get_class($item);
    }
}
