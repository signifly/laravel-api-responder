<?php

namespace R4nkt\Responder\Contracts;

use Illuminate\Contracts\Support\Responsable;

interface Responder
{
    public function respond($data): Responsable;
}
