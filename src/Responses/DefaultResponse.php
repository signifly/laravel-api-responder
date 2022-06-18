<?php

namespace R4nkt\Responder\Responses;

use Illuminate\Http\JsonResponse;

class DefaultResponse extends Response
{
    /** @var mixed */
    protected $data;

    /** @var string */
    protected $resourceClass;

    public function __construct($data, ?string $resourceClass = null)
    {
        $this->data = $data;
        $this->resourceClass = $resourceClass;
    }

    public function toResponse($request)
    {
        if (is_null($this->resourceClass)) {
            return new JsonResponse($this->data, $this->statusCode);
        }

        return (new $this->resourceClass($this->data))
            ->toResponse($request)
            ->setStatusCode($this->statusCode);
    }
}
