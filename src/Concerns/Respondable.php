<?php

namespace R4nkt\Responder\Concerns;

use Illuminate\Contracts\Support\Responsable;
use R4nkt\Responder\Contracts\Responder;

trait Respondable
{
    protected function respond($data, ?string $resourceClass = null): Responsable
    {
        return app(Responder::class)->respond($data, $resourceClass);
    }
}
