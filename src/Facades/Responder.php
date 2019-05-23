<?php

namespace Signifly\Responder\Facades;

use Illuminate\Support\Facades\Facade;
use Signifly\Responder\Contracts\Responder;

class Responder extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Responder::class;
    }
}
