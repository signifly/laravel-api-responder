<?php

namespace Signifly\Responder\Responses;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PaginatorResponse extends Response
{
    /** @var \Illuminate\Contracts\Pagination\LengthAwarePaginator */
    protected $paginator;

    /** @var string */
    protected $resourceClass;

    public function __construct(
        LengthAwarePaginator $paginator,
        ?string $resourceClass = null
    ) {
        $this->paginator = $paginator;
        $this->resourceClass = $resourceClass;
    }

    public function toResponse($request)
    {
        if (empty($this->resourceClass)) {
            return $this->paginator;
        }

        return $this->resourceClass::collection($this->paginator)
            ->toResponse($request);
    }
}
