<?php

namespace R4nkt\Responder\Contracts;

interface ModelResolver
{
    public function resolve($data, string $type): ?string;
}
