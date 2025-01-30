<?php

namespace PS\LaravelAdapty\Exceptions;

class AdaptyValidationException extends AdaptyException
{
    public function __construct(
        string $message = 'Validation failed',
        int $code = 422,
        public readonly array $errors = []
    ) {
        parent::__construct($message, $code);
    }

    public static function fromResponse(array $response): static
    {
        return new static(
            $response['error']['message'] ?? 'Validation error',
            $response['error']['code'] ?? 422,
            $response['error']['errors'] ?? []
        );
    }
}