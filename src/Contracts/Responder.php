<?php

namespace Signifly\Responder\Contracts;

use Illuminate\Contracts\Support\Responsable;

interface Responder
{
    public function respond($data): Responsable;
}
