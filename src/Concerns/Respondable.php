<?php

namespace Signifly\Responder\Concerns;

use Signifly\Responder\Contracts\Responder;

trait Respondable
{
    protected function respond($data)
    {
        return app(Responder::class)->respond($data);
    }
}
