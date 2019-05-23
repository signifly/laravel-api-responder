<?php

namespace Signifly\Responder\Contracts;

interface ResourceResolver
{
    public function resolve(?string $model): ?string;
}
