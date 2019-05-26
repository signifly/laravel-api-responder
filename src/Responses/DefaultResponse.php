<?php

namespace Signifly\Responder\Responses;

use Illuminate\Http\JsonResponse;

class DefaultResponse extends Response
{
    /** @var mixed */
    protected $data;

    /** @var int */
    protected $statusCode = 200;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function setStatusCode(int $statusCode): self
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    public function toResponse($request)
    {
        return new JsonResponse($this->data, $this->statusCode);
    }
}
