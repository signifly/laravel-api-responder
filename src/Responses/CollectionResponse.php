<?php

namespace R4nkt\Responder\Responses;

use Illuminate\Support\Collection;

class CollectionResponse extends Response
{
    /** @var \Illuminate\Support\Collection */
    protected $collection;

    /** @var string */
    protected $resourceClass;

    public function __construct(Collection $collection, ?string $resourceClass = null)
    {
        $this->collection = $collection;
        $this->resourceClass = $resourceClass;
    }

    public function toResponse($request)
    {
        if (empty($this->resourceClass)) {
            return (new DefaultResponse($this->collection))
                ->setStatusCode($this->statusCode)
                ->toResponse($request);
        }

        return $this->resourceClass::collection($this->collection)
            ->toResponse($request)
            ->setStatusCode($this->statusCode);
    }
}
