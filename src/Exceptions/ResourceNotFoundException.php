<?php

namespace R4nkt\Responder\Exceptions;

use Exception;

class ResourceNotFoundException extends Exception
{
    public static function for(string $resourceClass): self
    {
        return new self(
            sprintf('The resource `%s` could not be found.', $resourceClass)
        );
    }
}
