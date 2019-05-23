<?php

namespace Signifly\Responder\Responses;

use Illuminate\Http\JsonResponse;

class DefaultResponse extends Response
{
    /** @var mixed */
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function toResponse($request)
    {
        return new JsonResponse($this->data);
    }
}
