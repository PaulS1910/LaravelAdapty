<?php

declare(strict_types=1);

namespace PS\LaravelAdapty\DTO;

/**
 * For subscriptions Adapty also requires originally_purchased_at, expires_at and renew_status.
 */
class Transaction implements \JsonSerializable
{
    private string $environment;

    private Offer $offer;

    private bool $isFamilyShared;

    private string $refundedAt;

    private ?string $cancellationReason;

    private string $variationId;

    private string $renewStatusChangedAt;

    private ?string $billingIssueDetectedAt;

    private string $gracePeriodExpiresAt;

    private string $originallyPurchasedAt;

    private bool $renewStatus;

    private ?string $expiresAt;

    /**
     * @param  string  $purchaseType  one_time_purchase or subscription
     * @param  string  $store  app_store, play_store, stripe, paddle or a custom store ID
     * @param  string  $storeTransactionId  Up to 50 characters
     */
    public function __construct(
        private string $purchaseType,
        private string $store,
        private string $storeProductId,
        private string $storeTransactionId,
        private string $storeOriginalTransactionId,
        private Price $price,
        private string $purchasedAt,
    ) {
        $values = [
            $this->purchaseType,
            $this->store,
            $this->storeProductId,
            $this->storeTransactionId,
            $this->storeOriginalTransactionId,
            $this->purchasedAt,
        ];
        foreach ($values as $value) {
            if (empty($value)) {
                throw new \InvalidArgumentException('Transaction properties can not be empty');
            }
        }
    }

    /**
     * @param  string  $environment  Production or Sandbox
     */
    public function setEnvironment(string $environment): void
    {
        $this->environment = $environment;
    }

    public function setOffer(Offer $offer): void
    {
        $this->offer = $offer;
    }

    public function setIsFamilyShared(bool $isFamilyShared): void
    {
        $this->isFamilyShared = $isFamilyShared;
    }

    public function setRefundedAt(string $refundedAt): void
    {
        $this->refundedAt = $refundedAt;
    }

    /**
     * @param  string|null  $cancellationReason  billing_error, cancelled_by_developer, new_subscription_replace, price_increase,
     *                                           product_was_not_available, refund, unknown, upgraded, voluntarily_cancelled
     *                                           or adapty_revoked
     */
    public function setCancellationReason(?string $cancellationReason): void
    {
        $this->cancellationReason = $cancellationReason;
    }

    /**
     * @param  string  $variationId  Paywall variation ID, used for A/B test attribution
     */
    public function setVariationId(string $variationId): void
    {
        $this->variationId = $variationId;
    }

    public function setRenewStatusChangedAt(string $renewStatusChangedAt): void
    {
        $this->renewStatusChangedAt = $renewStatusChangedAt;
    }

    public function setBillingIssueDetectedAt(?string $billingIssueDetectedAt): void
    {
        $this->billingIssueDetectedAt = $billingIssueDetectedAt;
    }

    public function setGracePeriodExpiresAt(string $gracePeriodExpiresAt): void
    {
        $this->gracePeriodExpiresAt = $gracePeriodExpiresAt;
    }

    public function setOriginallyPurchasedAt(string $originallyPurchasedAt): void
    {
        $this->originallyPurchasedAt = $originallyPurchasedAt;
    }

    public function setRenewStatus(bool $renewStatus): void
    {
        $this->renewStatus = $renewStatus;
    }

    public function setExpiresAt(?string $expiresAt): void
    {
        $this->expiresAt = $expiresAt;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_filter([
            'purchase_type' => $this->purchaseType ?? null,
            'store' => $this->store ?? null,
            'environment' => $this->environment ?? null,
            'store_product_id' => $this->storeProductId ?? null,
            'store_transaction_id' => $this->storeTransactionId ?? null,
            'store_original_transaction_id' => $this->storeOriginalTransactionId ?? null,
            'offer' => isset($this->offer) ? $this->offer->toArray() : null,
            'is_family_shared' => $this->isFamilyShared ?? null,
            'price' => $this->price->toArray() ?? null,
            'purchased_at' => $this->purchasedAt ?? null,
            'refunded_at' => $this->refundedAt ?? null,
            'cancellation_reason' => $this->cancellationReason ?? null,
            'variation_id' => $this->variationId ?? null,
            'originally_purchased_at' => $this->originallyPurchasedAt ?? null,
            'expires_at' => $this->expiresAt ?? null,
            'renew_status' => $this->renewStatus ?? null,
            'renew_status_changed_at' => $this->renewStatusChangedAt ?? null,
            'billing_issue_detected_at' => $this->billingIssueDetectedAt ?? null,
            'grace_period_expires_at' => $this->gracePeriodExpiresAt ?? null,
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
