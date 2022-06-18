<?php

namespace R4nkt\Responder\Responses;

use Illuminate\Contracts\Support\Responsable;

abstract class Response implements Responsable
{
    /** @var int */
    protected $statusCode = 200;

    public function setStatusCode(int $statusCode): self
    {
        $this->statusCode = $statusCode;

        return $this;
    }
}
