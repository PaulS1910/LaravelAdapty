<?php

namespace PS\LaravelAdapty\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static array getProfile(string $profileId, string $platform)
 * @method static array createProfile(string $customerId, string $platform, Profile $profile)
 * @method static array updateProfile(string $profileId, string $platform, Profile $profile)
 * @method static array deleteProfile(string $profileId, string $platform)
 * @method static array grantAccessLevel(string $profileId, string $platform, AccessLevel $accessLevel)
 * @method static array revokeAccessLevel(string $profileId, string $platform, AccessLevel $accessLevel)
 * @method static array setTransaction(string $profileId, string $platform, Transaction $transaction)
 */
class Adapty extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'adapty';
    }
}