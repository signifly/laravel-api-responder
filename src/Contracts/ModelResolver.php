<?php

namespace Signifly\Responder\Contracts;

interface ModelResolver
{
    public function resolve($data, string $type): string
}
