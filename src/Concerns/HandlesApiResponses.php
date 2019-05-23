<?php

namespace Signifly\Responder\Concerns;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Signifly\Responder\Responses\ModelResponse;
use Signifly\Responder\Responses\PaginatorResponse;
use Signifly\Responder\Responses\CollectionResponse;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

trait HandlesApiResponses
{
    /**
     * Respond for a collection.
     *
     * @param  Collection $data
     * @param  string $model
     * @return mixed
     */
    protected function respondForCollection(Collection $data, string $model)
    {
        return new CollectionResponse($data, $model);
    }

    /**
     * Respond for a given model.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param int|null $statusCode
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    protected function respondForModel(Model $model, ?int $statusCode = null)
    {
        return new ModelResponse($model, $statusCode);
    }

    /**
     * Respond for a paginator.
     *
     * @param  LengthAwarePaginator $data
     * @param  string $model
     * @return mixed
     */
    protected function respondForPaginator(LengthAwarePaginator $data, string $model)
    {
        return new PaginatorResponse($data, $model);
    }
}
