<?php

namespace Signifly\Responder\Responses;

use Illuminate\Support\Collection;

class CollectionResponse extends Response
{
    /** @var \Illuminate\Support\Collection */
    protected $collection;

    /** @var string */
    protected $resourceClass;

    /** @var int */
    protected $statusCode = 200;

    public function __construct(Collection $collection, ?string $resourceClass = null)
    {
        $this->collection = $collection;
        $this->resourceClass = $resourceClass;
    }

    public function setStatusCode(int $statusCode): self
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    public function toResponse($request)
    {
        if (empty($this->resourceClass)) {
            return $this->collection;
        }

        return $this->resourceClass::collection($this->collection)
            ->toResponse($request)
            ->setStatusCode($this->statusCode);
    }
}
