<?php

namespace PS\LaravelAdapty\Tests\Feature;

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use PS\LaravelAdapty\DTO\AccessLevel;
use PS\LaravelAdapty\DTO\Offer;
use PS\LaravelAdapty\DTO\Price;
use PS\LaravelAdapty\DTO\Profile;
use PS\LaravelAdapty\DTO\Transaction;
use PS\LaravelAdapty\Facades\Adapty;
use PS\LaravelAdapty\Tests\TestCase;

/**
 * Characterization tests: they pin the HTTP requests the package sends today
 * (as run in production via the andrewnovikof/laravel-adapty fork), so that 1.x
 * fixes can be checked against them.
 */
class RequestsTest extends TestCase
{
    private const PROFILE_ID = '00000000-0000-0000-0000-000000000001';

    private const CUSTOMER_USER_ID = 'customer-42';

    protected function setUp(): void
    {
        parent::setUp();

        Http::fake(['*' => Http::response(['data' => ['profile_id' => self::PROFILE_ID]])]);
    }

    public function test_get_profile(): void
    {
        $result = Adapty::getProfile(self::PROFILE_ID, 'iOS');

        $this->assertSame(['data' => ['profile_id' => self::PROFILE_ID]], $result);
        $this->assertSentOnce('GET', 'profile/', ['adapty-profile-id' => self::PROFILE_ID], null);
    }

    public function test_create_profile(): void
    {
        $profile = new Profile;
        $profile->setFirstName('John');
        $profile->setEmail('john@example.com');
        $profile->setCustomAttributes([['key' => 'level', 'value' => 3]]);

        Adapty::createProfile(self::CUSTOMER_USER_ID, 'Android', $profile);

        $this->assertSentOnce('POST', 'profile/', ['adapty-customer-user-id' => self::CUSTOMER_USER_ID], [
            'first_name' => 'John',
            'email' => 'john@example.com',
            'custom_attributes' => [['key' => 'level', 'value' => 3]],
        ], platform: 'Android');
    }

    public function test_update_profile(): void
    {
        $profile = new Profile;
        $profile->setLastName('Doe');
        $profile->setStoreCountry('US');

        Adapty::updateProfile(self::PROFILE_ID, 'iOS', $profile);

        $this->assertSentOnce('PATCH', 'profile/', ['adapty-profile-id' => self::PROFILE_ID], [
            'last_name' => 'Doe',
            'store_country' => 'US',
        ]);
    }

    public function test_update_profile_drops_false_and_empty_values(): void
    {
        $profile = new Profile;
        $profile->setFirstName('John');
        $profile->setAnalyticsDisabled(false);
        $profile->setEmail('');
        $profile->setCustomAttributes([]);

        Adapty::updateProfile(self::PROFILE_ID, 'iOS', $profile);

        $this->assertSentOnce('PATCH', 'profile/', ['adapty-profile-id' => self::PROFILE_ID], [
            'first_name' => 'John',
        ]);
    }

    public function test_delete_profile_request(): void
    {
        Adapty::deleteProfile(self::PROFILE_ID, 'iOS');

        $this->assertSentOnce('DELETE', 'profile/', ['adapty-profile-id' => self::PROFILE_ID], null);
    }

    public function test_grant_access_level(): void
    {
        $accessLevel = new AccessLevel('premium');
        $accessLevel->setStartsAt('2026-01-01T00:00:00+00:00');
        $accessLevel->setExpiresAt('2026-02-01T00:00:00+00:00');

        Adapty::grantAccessLevel(self::PROFILE_ID, 'iOS', $accessLevel);

        $this->assertSentOnce('POST', 'purchase/profile/grant/access-level/', ['adapty-profile-id' => self::PROFILE_ID], [
            'access_level_id' => 'premium',
            'starts_at' => '2026-01-01T00:00:00+00:00',
            'expires_at' => '2026-02-01T00:00:00+00:00',
        ]);
    }

    public function test_revoke_access_level(): void
    {
        $accessLevel = new AccessLevel('premium');
        $accessLevel->setRevokeAt('2026-03-01T00:00:00+00:00');

        Adapty::revokeAccessLevel(self::PROFILE_ID, 'iOS', $accessLevel);

        $this->assertSentOnce('POST', 'purchase/profile/revoke/access-level/', ['adapty-profile-id' => self::PROFILE_ID], [
            'access_level_id' => 'premium',
            'revoke_at' => '2026-03-01T00:00:00+00:00',
        ]);
    }

    public function test_set_transaction(): void
    {
        $transaction = $this->makeTransaction(new Price('US', 'USD', 9.99));
        $transaction->setEnvironment('Production');
        $transaction->setOffer(new Offer('introductory', 'free_trial', 'offer-1'));
        $transaction->setOriginallyPurchasedAt('2026-01-01T00:00:00+00:00');
        $transaction->setExpiresAt('2026-02-01T00:00:00+00:00');
        $transaction->setRenewStatus(true);

        Adapty::setTransaction(self::PROFILE_ID, 'iOS', $transaction);

        $this->assertSentOnce('POST', 'purchase/set/transaction/', ['adapty-profile-id' => self::PROFILE_ID], [
            'purchase_type' => 'subscription',
            'store' => 'app_store',
            'environment' => 'Production',
            'store_product_id' => 'monthly',
            'store_transaction_id' => 'tx-2',
            'store_original_transaction_id' => 'tx-1',
            'offer' => [
                'offer_category' => 'introductory',
                'offer_type' => 'free_trial',
                'offer_id' => 'offer-1',
            ],
            'price' => ['country' => 'US', 'currency' => 'USD', 'value' => 9.99],
            'purchased_at' => '2026-01-01T00:00:00+00:00',
            'originally_purchased_at' => '2026-01-01T00:00:00+00:00',
            'expires_at' => '2026-02-01T00:00:00+00:00',
            'renew_status' => true,
        ]);
    }

    /**
     * Behaviour of the production fork (18a0734): only null values are dropped from a transaction,
     * so false, empty strings and empty arrays are sent as is.
     */
    public function test_set_transaction_keeps_false_and_empty_values_like_fork(): void
    {
        $transaction = $this->makeTransaction(new Price('US', 'USD', 9.99));
        $transaction->setIsFamilyShared(false);
        $transaction->setRenewStatus(false);
        $transaction->setVariationId('');
        $transaction->setCancellationReason(null);

        Adapty::setTransaction(self::PROFILE_ID, 'iOS', $transaction);

        $this->assertSentOnce('POST', 'purchase/set/transaction/', ['adapty-profile-id' => self::PROFILE_ID], [
            'purchase_type' => 'subscription',
            'store' => 'app_store',
            'store_product_id' => 'monthly',
            'store_transaction_id' => 'tx-2',
            'store_original_transaction_id' => 'tx-1',
            'is_family_shared' => false,
            'price' => ['country' => 'US', 'currency' => 'USD', 'value' => 9.99],
            'purchased_at' => '2026-01-01T00:00:00+00:00',
            'variation_id' => '',
            'renew_status' => false,
        ]);
    }

    private function makeTransaction(Price $price): Transaction
    {
        return new Transaction(
            purchaseType: 'subscription',
            store: 'app_store',
            storeProductId: 'monthly',
            storeTransactionId: 'tx-2',
            storeOriginalTransactionId: 'tx-1',
            price: $price,
            purchasedAt: '2026-01-01T00:00:00+00:00',
        );
    }

    /**
     * @param  array<string, string>  $identity
     * @param  array<string, mixed>|null  $body
     */
    private function assertSentOnce(string $method, string $path, array $identity, ?array $body, string $platform = 'iOS'): void
    {
        Http::assertSentCount(1);
        Http::assertSent(function (Request $request) use ($method, $path, $identity, $body, $platform) {
            $this->assertSame($method, $request->method());
            $this->assertSame(self::BASE_URL.$path, $request->url());
            $this->assertSame(['Api-Key '.self::API_KEY], $request->header('Authorization'));
            $this->assertSame([$platform], $request->header('adapty-platform'));

            foreach ($identity as $header => $value) {
                $this->assertSame([$value], $request->header($header));
            }

            foreach (['adapty-profile-id', 'adapty-customer-user-id'] as $header) {
                if (! array_key_exists($header, $identity)) {
                    $this->assertFalse($request->hasHeader($header), "Unexpected header {$header}");
                }
            }

            if ($body !== null) {
                $this->assertSame($body, $request->data());
            }

            return true;
        });
    }
}
