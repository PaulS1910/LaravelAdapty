<?php

namespace PS\LaravelAdapty\Exceptions;

use Illuminate\Http\Client\HttpClientException;

abstract class AdaptyException extends HttpClientException
{
    public function __construct(
        string $message = 'Adapty API Error',
        int $statusCode = 500,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $statusCode, $previous);
    }

    public static function fromResponse(array $response): static
    {
        return new static(
            $response['error']['message'] ?? 'Unknown API error',
            $response['error']['code'] ?? 500
        );
    }
}