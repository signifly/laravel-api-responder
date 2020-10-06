<?php

namespace Signifly\Responder\Concerns;

use Illuminate\Contracts\Support\Responsable;
use Signifly\Responder\Contracts\Responder;

trait Respondable
{
    protected function respond($data, ?string $resourceClass = null): Responsable
    {
        return app(Responder::class)->respond($data, $resourceClass);
    }
}
