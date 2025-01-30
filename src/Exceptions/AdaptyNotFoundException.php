<?php

namespace PS\LaravelAdapty\Exceptions;

class AdaptyNotFoundException extends AdaptyException
{
    public function __construct(string $message = 'Resource not found', int $code = 404)
    {
        parent::__construct($message, $code);
    }
}