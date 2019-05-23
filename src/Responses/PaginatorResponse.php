<?php

namespace Signifly\Responder\Responses;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PaginatorResponse extends Response
{
    /** @var string */
    protected $model;

    /** @var \Illuminate\Contracts\Pagination\LengthAwarePaginator */
    protected $paginator;

    public function __construct(LengthAwarePaginator $paginator, string $model)
    {
        $this->paginator = $paginator;
        $this->model = $model;
    }

    public function toResponse($request)
    {
        $resourceClass = $this->getResourceClassFor($this->model);

        return $resourceClass::collection($this->paginator)->toResponse($request);
    }
}
