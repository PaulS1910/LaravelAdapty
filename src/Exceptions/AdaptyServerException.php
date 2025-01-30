<?php

namespace PS\LaravelAdapty\Exceptions;

class AdaptyServerException extends AdaptyException
{
    public function __construct(string $message = 'Server error', int $code = 500)
    {
        parent::__construct($message, $code);
    }
}