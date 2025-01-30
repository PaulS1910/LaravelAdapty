<?php

namespace PS\LaravelAdapty\Exceptions;

class AdaptyClientException extends AdaptyException
{
    public function __construct(string $message = 'Client error', int $code = 400)
    {
        parent::__construct($message, $code);
    }
}