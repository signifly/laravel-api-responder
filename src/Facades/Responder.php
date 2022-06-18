<?php

namespace R4nkt\Responder\Facades;

use Illuminate\Support\Facades\Facade;
use R4nkt\Responder\Contracts\Responder as ResponderContract;

class Responder extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return ResponderContract::class;
    }
}
