<?php

namespace Signifly\Responder\Concerns;

use Signifly\Responder\Contracts\Responder;
use Illuminate\Contracts\Support\Responsable;

trait Respondable
{
    protected function respond($data): Responsable
    {
        return app(Responder::class)->respond($data);
    }
}
