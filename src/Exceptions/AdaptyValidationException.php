<?php

namespace PS\LaravelAdapty\Exceptions;

class AdaptyValidationException extends AdaptyException
{
    /**
     * @param  list<array{source: string|null, errors: list<string>}>  $errors
     */
    public function __construct(
        string $message = 'Validation failed',
        int $code = 422,
        public readonly array $errors = []
    ) {
        parent::__construct($message, $code);
    }

    /**
     * @param  array<string, mixed>  $response  Decoded Adapty error body: errors, error_code, status_code
     */
    public static function fromResponse(array $response): static
    {
        return new static(
            $response['error_code'] ?? 'Validation error',
            $response['status_code'] ?? 422,
            $response['errors'] ?? []
        );
    }
}
