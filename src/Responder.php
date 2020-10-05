<?php

namespace Signifly\Responder;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;
use Signifly\Responder\Contracts\ModelResolver;
use Signifly\Responder\Contracts\ResourceResolver;
use Signifly\Responder\Contracts\Responder as Contract;
use Signifly\Responder\Responses\CollectionResponse;
use Signifly\Responder\Responses\DefaultResponse;
use Signifly\Responder\Responses\ModelResponse;
use Signifly\Responder\Responses\PaginatorResponse;

class Responder implements Contract
{
    /** @var \Signifly\Responder\Contracts\ModelResolver */
    protected $modelResolver;

    /** @var \Signifly\Responder\Contracts\ResourceResolver */
    protected $resourceResolver;

    public function __construct(
        ModelResolver $modelResolver,
        ResourceResolver $resourceResolver
    ) {
        $this->modelResolver = $modelResolver;
        $this->resourceResolver = $resourceResolver;
    }

    /**
     * Respond to data.
     *
     * @param  mixed $data
     * @return \Illuminate\Contracts\Support\Responsable
     */
    public function respond($data, ?string $resourceClass = null): Responsable
    {
        if ($data instanceof Collection) {
            return $this->respondForCollection($data, $resourceClass);
        }

        if ($data instanceof Model) {
            return $this->respondForModel($data, $resourceClass);
        }

        if ($data instanceof LengthAwarePaginator) {
            return $this->respondForPaginator($data, $resourceClass);
        }

        return new DefaultResponse($data, $resourceClass);
    }

    /**
     * Respond for a collection.
     *
     * @param  \Illuminate\Support\Collection $data
     * @return \Signifly\Responder\Responses\CollectionResponse
     */
    protected function respondForCollection(Collection $data, ?string $resourceClass)
    {
        if (is_null($resourceClass)) {
            $modelClass = $this->modelResolver->resolve($data, 'collection');

            $resourceClass = empty($modelClass)
                ? config('responder.default_resource', JsonResource::class)
                : $this->resourceResolver->resolve($modelClass);
        }

        return new CollectionResponse($data, $resourceClass);
    }

    /**
     * Respond for a given model.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return \Signifly\Responder\Responses\ModelResponse
     */
    protected function respondForModel(Model $model, ?string $resourceClass)
    {
        if (is_null($resourceClass)) {
            $resourceClass = $this->resourceResolver->resolve(get_class($model));
        }

        return new ModelResponse($model, $resourceClass);
    }

    /**
     * Respond for a paginator.
     *
     * @param  \Illuminate\Contracts\Pagination\LengthAwarePaginator $data
     * @return \Signifly\Responder\Responses\PaginatorResponse
     */
    protected function respondForPaginator(LengthAwarePaginator $data, ?string $resourceClass)
    {
        $modelClass = $this->modelResolver->resolve($data, 'paginator');

        if (is_null($resourceClass)) {
            $resourceClass = empty($modelClass)
                ? config('responder.default_resource', JsonResource::class)
                : $this->resourceResolver->resolve($modelClass);
        }

        return new PaginatorResponse($data, $resourceClass);
    }
}
