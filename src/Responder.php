<?php

namespace Signifly\Responder;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Support\Responsable;
use Signifly\Responder\Support\ModelResolver;
use Signifly\Responder\Responses\ModelResponse;
use Signifly\Responder\Responses\DefaultResponse;
use Signifly\Responder\Contracts\ResourceResolver;
use Signifly\Responder\Responses\PaginatorResponse;
use Signifly\Responder\Responses\CollectionResponse;
use Signifly\Responder\Contracts\Responder as Contract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class Responder implements Contract
{
    /** @var \Signifly\Responder\Support\ModelResolver */
    protected $modelResolver;

    /** @var \Signifly\Responder\Support\ResourceResolver */
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
    public function respond($data): Responsable
    {
        if ($data instanceof Collection) {
            return $this->respondForCollection($data);
        }

        if ($data instanceof Model) {
            return $this->respondForModel($data);
        }

        if ($data instanceof LengthAwarePaginator) {
            return $this->respondForPaginator($data);
        }

        return new DefaultResponse($data);
    }

    /**
     * Respond for a collection.
     *
     * @param  \Illuminate\Support\Collection $data
     * @param  string $model
     * @return \Signifly\Responder\Responses\CollectionResponse
     */
    protected function respondForCollection(Collection $data)
    {
        $modelClass = $model ?? $this->modelResolver->resolve($data, 'collection');
        $resourceClass = $this->resourceResolver->resolve($modelClass);
        return new CollectionResponse($data, $resourceClass);
    }

    /**
     * Respond for a given model.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return \Signifly\Responder\Responses\ModelResponse
     */
    protected function respondForModel(Model $model)
    {
        $resourceClass = $this->resourceResolver->resolve(get_class($model));
        return new ModelResponse($model, $resourceClass);
    }

    /**
     * Respond for a paginator.
     *
     * @param  \Illuminate\Contracts\Pagination\LengthAwarePaginator $data
     * @param  string $model
     * @return \Signifly\Responder\Responses\PaginatorResponse
     */
    protected function respondForPaginator(LengthAwarePaginator $data)
    {
        $modelClass = $model ?? $this->modelResolver->resolve($data, 'paginator');
        $resourceClass = $this->resourceResolver->resolve($modelClass);
        return new PaginatorResponse($data, $resourceClass);
    }
}
