<?php

declare(strict_types=1);

namespace PS\LaravelAdapty\DTO;

class Transaction implements \JsonSerializable
{
    private string $environment;

    private Offer $offer;

    private bool $isFamilyShared;

    private string $refundedAt;

    private string|null $cancellationReason;

    private string $variationId;

    private string $renewStatusChangedAt;

    private string|null $billingIssueDetectedAt;

    private string $gracePeriodExpiresAt;

    public function __construct(
        private string $purchaseType,
        private string $store,
        private string $storeProductId,
        private string $storeTransactionId,
        private string $storeOriginalTransactionId,
        private Price $price,
        private string $purchasedAt,
        private string $originallyPurchasedAt,
        private bool $renewStatus,
        private string|null $expiresAt,
    ) {
        $values = array(
            $this->purchaseType,
            $this->store,
            $this->storeProductId,
            $this->storeTransactionId,
            $this->storeOriginalTransactionId,
            $this->purchasedAt,
            $this->originallyPurchasedAt,
            $this->renewStatus,
            $this->expiresAt,
        );
        foreach ($values as $value) {
            if (empty($value)) {
                throw new \InvalidArgumentException("Offer properties can not be empty");
            }
        }
    }

    /**
     * @param string $environment
     * @return void
     */
    public function setEnvironment(string $environment): void
    {
        $this->environment = $environment;
    }

    /**
     * @param Offer $offer
     * @return void
     */
    public function setOffer(Offer $offer): void
    {
        $this->offer = $offer;
    }

    /**
     * @param bool $isFamilyShared
     * @return void
     */
    public function setIsFamilyShared(bool $isFamilyShared): void
    {
        $this->isFamilyShared = $isFamilyShared;
    }

    /**
     * @param string $refundedAt
     * @return void
     */
    public function setRefundedAt(string $refundedAt): void
    {
        $this->refundedAt = $refundedAt;
    }

    /**
     * @param string|null $cancellationReason
     * @return void
     */
    public function setCancellationReason(?string $cancellationReason): void
    {
        $this->cancellationReason = $cancellationReason;
    }

    /**
     * @param string $variationId
     * @return void
     */
    public function setVariationId(string $variationId): void
    {
        $this->variationId = $variationId;
    }

     /**
     * @param string $renewStatusChangedAt
     * @return void
     */
    public function setRenewStatusChangedAt(string $renewStatusChangedAt): void
    {
        $this->renewStatusChangedAt = $renewStatusChangedAt;
    }

    /**
     * @param string|null $billingIssueDetectedAt
     * @return void
     */
    public function setBillingIssueDetectedAt(?string $billingIssueDetectedAt): void
    {
        $this->billingIssueDetectedAt = $billingIssueDetectedAt;
    }

    /**
     * @param string $gracePeriodExpiresAt
     * @return void
     */
    public function setgracePeriodExpiresAt(string $gracePeriodExpiresAt): void
    {
        $this->gracePeriodExpiresAt = $gracePeriodExpiresAt;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return array_filter([
            'purchase_type' => $this->purchaseType,
            'store' => $this->store,
            'environment' => $this->environment,
            'store_product_id' => $this->storeProductId,
            'store_transaction_id' => $this->storeTransactionId,
            'store_original_transaction_id' => $this->storeOriginalTransactionId,
            'offer' => $this->offer->toArray(),
            'is_family_shared' => $this->isFamilyShared,
            'price' => $this->price->toArray(),
            'purchased_at' => $this->purchasedAt,
            'refunded_at' => $this->refundedAt,
            'cancellation_reason' => $this->cancellationReason,
            'variation_id' => $this->variationId,
            'originally_purchased_at' => $this->originallyPurchasedAt,
            'expires_at' => $this->expiresAt,
            'renew_status' => $this->renewStatus,
            'renew_status_changed_at' => $this->renewStatusChangedAt,
            'billing_issue_detected_at' => $this->billingIssueDetectedAt,
            'grace_period_expires_at' => $this->gracePeriodExpiresAt,
        ]);
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
