<?php

namespace PS\LaravelAdapty\Exceptions;

class AdaptyAuthenticationException extends AdaptyException
{
    public function __construct(string $message = 'Authentication failed', int $code = 401)
    {
        parent::__construct($message, $code);
    }
}