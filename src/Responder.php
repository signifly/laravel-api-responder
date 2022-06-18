<?php

namespace R4nkt\Responder;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;
use R4nkt\Responder\Contracts\ModelResolver;
use R4nkt\Responder\Contracts\ResourceResolver;
use R4nkt\Responder\Contracts\Responder as Contract;
use R4nkt\Responder\Responses\CollectionResponse;
use R4nkt\Responder\Responses\DefaultResponse;
use R4nkt\Responder\Responses\ModelResponse;
use R4nkt\Responder\Responses\PaginatorResponse;

class Responder implements Contract
{
    /** @var \R4nkt\Responder\Contracts\ModelResolver */
    protected $modelResolver;

    /** @var \R4nkt\Responder\Contracts\ResourceResolver */
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
     * @return \R4nkt\Responder\Responses\CollectionResponse
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
     * @return \R4nkt\Responder\Responses\ModelResponse
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
     * @return \R4nkt\Responder\Responses\PaginatorResponse
     */
    protected function respondForPaginator(LengthAwarePaginator $data, ?string $resourceClass)
    {
        if (is_null($resourceClass)) {
            $modelClass = $this->modelResolver->resolve($data, 'paginator');

            $resourceClass = empty($modelClass)
                ? config('responder.default_resource', JsonResource::class)
                : $this->resourceResolver->resolve($modelClass);
        }

        return new PaginatorResponse($data, $resourceClass);
    }
}
