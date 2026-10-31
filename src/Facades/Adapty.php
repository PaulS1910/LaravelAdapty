<?php

namespace PS\LaravelAdapty\Facades;

use Illuminate\Support\Facades\Facade;
use PS\LaravelAdapty\Services\AdaptyService;

/**
 * @method static array<string, mixed> getProfile(string $profileId, string $platform)
 * @method static array<string, mixed> createProfile(string $customerId, string $platform, \PS\LaravelAdapty\DTO\Profile $profile)
 * @method static array<string, mixed> updateProfile(string $profileId, string $platform, \PS\LaravelAdapty\DTO\Profile $profile)
 * @method static array<string, mixed> deleteProfile(string $profileId, string $platform)
 * @method static array<string, mixed> grantAccessLevel(string $profileId, string $platform, \PS\LaravelAdapty\DTO\AccessLevel $accessLevel)
 * @method static array<string, mixed> revokeAccessLevel(string $profileId, string $platform, \PS\LaravelAdapty\DTO\AccessLevel $accessLevel)
 * @method static array<string, mixed> setTransaction(string $profileId, string $platform, \PS\LaravelAdapty\DTO\Transaction $transaction)
 *
 * @see AdaptyService
 */
class Adapty extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'adapty';
    }
}
