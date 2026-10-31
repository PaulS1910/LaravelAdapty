<?php

namespace PS\LaravelAdapty\Tests\Feature;

use Illuminate\Http\Client\HttpClientException;
use Illuminate\Support\Facades\Http;
use PHPUnit\Framework\Attributes\DataProvider;
use PS\LaravelAdapty\Exceptions\AdaptyAuthenticationException;
use PS\LaravelAdapty\Exceptions\AdaptyClientException;
use PS\LaravelAdapty\Exceptions\AdaptyException;
use PS\LaravelAdapty\Exceptions\AdaptyNotFoundException;
use PS\LaravelAdapty\Exceptions\AdaptyServerException;
use PS\LaravelAdapty\Exceptions\AdaptyValidationException;
use PS\LaravelAdapty\Facades\Adapty;
use PS\LaravelAdapty\Tests\TestCase;

/**
 * Characterization tests for error mapping, using the error body format from the Adapty docs:
 * {"errors": [{"source": ..., "errors": [...]}], "error_code": ..., "status_code": ...}.
 */
class ErrorsTest extends TestCase
{
    /**
     * @return array<string, array{int, class-string<AdaptyException>, string}>
     */
    public static function statuses(): array
    {
        return [
            '400 bad request' => [400, AdaptyClientException::class, 'validation_error'],
            '401 unauthorized' => [401, AdaptyAuthenticationException::class, 'unauthorized'],
            '404 not found' => [404, AdaptyNotFoundException::class, 'profile_not_found'],
            '422 unprocessable' => [422, AdaptyValidationException::class, 'validation_error'],
            '500 server error' => [500, AdaptyServerException::class, 'internal_error'],
            '502 bad gateway' => [502, AdaptyServerException::class, 'bad_gateway'],
        ];
    }

    /**
     * @param  class-string<AdaptyException>  $exceptionClass
     */
    #[DataProvider('statuses')]
    public function test_error_status_is_mapped_to_exception(int $status, string $exceptionClass, string $errorCode): void
    {
        Http::fake(['*' => Http::response([
            'errors' => [['source' => 'non_field_errors', 'errors' => ['Something went wrong']]],
            'error_code' => $errorCode,
            'status_code' => $status,
        ], $status)]);

        try {
            Adapty::getProfile('profile-id', 'iOS');
            $this->fail('Exception was not thrown');
        } catch (AdaptyException $e) {
            $this->assertSame($exceptionClass, $e::class);
            $this->assertInstanceOf(HttpClientException::class, $e);
            $this->assertSame($errorCode, $e->getMessage());
            $this->assertSame($status, $e->getCode());
        }
    }

    public function test_validation_exception_exposes_errors(): void
    {
        $errors = [['source' => 'email', 'errors' => ['Enter a valid email address.']]];

        Http::fake(['*' => Http::response([
            'errors' => $errors,
            'error_code' => 'validation_error',
            'status_code' => 422,
        ], 422)]);

        try {
            Adapty::getProfile('profile-id', 'iOS');
            $this->fail('Exception was not thrown');
        } catch (AdaptyValidationException $e) {
            $this->assertSame($errors, $e->errors);
        }
    }

    /**
     * Without status_code in the body the code falls back to 500 regardless of the HTTP status.
     */
    public function test_error_without_json_body(): void
    {
        Http::fake(['*' => Http::response('Not Found', 404)]);

        try {
            Adapty::getProfile('profile-id', 'iOS');
            $this->fail('Exception was not thrown');
        } catch (AdaptyNotFoundException $e) {
            $this->assertSame('Unknown API error code', $e->getMessage());
            $this->assertSame(500, $e->getCode());
        }
    }
}
