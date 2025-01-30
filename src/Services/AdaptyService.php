<?php

namespace PS\LaravelAdapty\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use PS\LaravelAdapty\DTO\AccessLevel;
use PS\LaravelAdapty\DTO\Profile;
use PS\LaravelAdapty\DTO\Transaction;
use PS\LaravelAdapty\Exceptions\AdaptyAuthenticationException;
use PS\LaravelAdapty\Exceptions\AdaptyClientException;
use PS\LaravelAdapty\Exceptions\AdaptyNotFoundException;
use PS\LaravelAdapty\Exceptions\AdaptyServerException;
use PS\LaravelAdapty\Exceptions\AdaptyValidationException;

class AdaptyService
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('adapty.base_url');
    }
    public function getAuthHeaders(string $platform): array
    {
        return [
            'Authorization' => 'Api-Key ' . config('adapty.secret_token'),
            'Accept' => '*/*',
            'Content-Type' => 'application/json',
            'adapty-platform' => $platform
        ];
    }

    private function withProfileHeaders(array $headers, string $profileId): array
    {
        return array_merge($headers, [
            'adapty-profile-id' => $profileId
        ]);
    }

    private function withCustomerUserIdHeaders(array $headers, string $customerUserId): array
    {
        return array_merge($headers, [
            'adapty-customer-user-id' => $customerUserId
        ]);
    }

    private function handleErrorResponse(Response $response): void
    {
        $status = $response->status();
        $body = $response->json() ?? [];

        $exceptionClass = match (true) {
            $status === 401 => AdaptyAuthenticationException::class,
            $status === 404 => AdaptyNotFoundException::class,
            $status === 422 => AdaptyValidationException::class,
            $status >= 500 => AdaptyServerException::class,
            default => AdaptyClientException::class,
        };

        if ($exceptionClass === AdaptyValidationException::class) {
            throw AdaptyValidationException::fromResponse($body);
        }

        throw $exceptionClass::fromResponse(array_merge($body, [
            'error' => array_merge($body['error'] ?? [], ['code' => $status])
        ]));
    }

    public function getProfile(string $profileId, string $platform): array
    {
        $response = Http::withHeaders(
            $this->withProfileHeaders($this->getAuthHeaders($platform), $profileId)
        )->get($this->baseUrl . "profile/");

        if ($response->failed()) {
            $this->handleErrorResponse($response);
        }

        return $response->json();
    }

    public function createProfile(string $customerId, string $platform, Profile $profile): array
    {
        $response = Http::withHeaders(
            $this->withCustomerUserIdHeaders($this->getAuthHeaders($platform), $customerId)
        )
            ->asJson()
            ->post($this->baseUrl . 'profile/', $profile->toArray());

        if ($response->failed()) {
            $this->handleErrorResponse($response);
        }

        return $response->json();
    }

    public function updateProfile(string $profileId, string $platform, Profile $profile): array
    {
        $response = Http::withHeaders(
            $this->withProfileHeaders($this->getAuthHeaders($platform), $profileId)
        )
            ->asJson()
            ->patch($this->baseUrl . 'profile/', $profile->toArray());

        if ($response->failed()) {
            $this->handleErrorResponse($response);
        }

        return $response->json();
    }

    public function deleteProfile(string $profileId, string $platform): array
    {
        $response = Http::withHeaders(
            $this->withProfileHeaders($this->getAuthHeaders($platform), $profileId)
        )->delete($this->baseUrl . 'profile/');

        if ($response->failed()) {
            $this->handleErrorResponse($response);
        }

        return $response->json();
    }

    public function grantAccessLevel(string $profileId, string $platform, AccessLevel $accessLevel): array
    {
        $response = Http::withHeaders(
            $this->withProfileHeaders($this->getAuthHeaders($platform), $profileId)
        )
            ->asJson()
            ->post($this->baseUrl . "purchase/profile/grant/access-level/", $accessLevel->toArray());

        if ($response->failed()) {
            $this->handleErrorResponse($response);
        }

        return $response->json();
    }

    public function revokeAccessLevel(string $profileId, string $platform, AccessLevel $accessLevel): array
    {
        $response = Http::withHeaders(
            $this->withProfileHeaders($this->getAuthHeaders($platform), $profileId)
        )
            ->asJson()
            ->post($this->baseUrl . "purchase/profile/revoke/access-level/", $accessLevel->toArray());

        if ($response->failed()) {
            $this->handleErrorResponse($response);
        }

        return $response->json();
    }

    public function setTransaction(string $profileId, string $platform, Transaction $transaction): array
    {
        $response = Http::withHeaders(
            $this->withProfileHeaders($this->getAuthHeaders($platform), $profileId)
        )
            ->asJson()
            ->post($this->baseUrl . "purchase/set/transaction/", $transaction->toArray());

        if ($response->failed()) {
            $this->handleErrorResponse($response);
        }

        return $response->json();
    }
}
