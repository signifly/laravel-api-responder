<?php

namespace R4nkt\Responder\Contracts;

interface ResourceResolver
{
    public function resolve(string $model): string;
}
