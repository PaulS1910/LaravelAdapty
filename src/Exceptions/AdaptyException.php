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

    /**
     * @param  array<string, mixed>  $response  Decoded Adapty error body: errors, error_code, status_code
     */
    public static function fromResponse(array $response): static
    {
        return new static(
            $response['error_code'] ?? 'Unknown API error code',
            $response['status_code'] ?? 500,
        );
    }
}
