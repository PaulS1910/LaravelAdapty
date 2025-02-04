<?php

declare(strict_types=1);

namespace PS\LaravelAdapty\DTO;

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

    public function __construct(
        private string $purchaseType,
        private string $store,
        private string $storeProductId,
        private string $storeTransactionId,
        private string $storeOriginalTransactionId,
        private Price $price,
        private string $purchasedAt,
    ) {
        $values = array(
            $this->purchaseType,
            $this->store,
            $this->storeProductId,
            $this->storeTransactionId,
            $this->storeOriginalTransactionId,
            $this->purchasedAt,
        );
        foreach ($values as $value) {
            if (empty($value)) {
                throw new \InvalidArgumentException("Transaction properties can not be empty");
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
     * @param ?string $cancellationReason
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
     * @param ?string $billingIssueDetectedAt
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
    public function setGracePeriodExpiresAt(string $gracePeriodExpiresAt): void
    {
        $this->gracePeriodExpiresAt = $gracePeriodExpiresAt;
    }

    /**
     * @param string $originallyPurchasedAt
     * @return void
     */
    public function setOriginallyPurchasedAt(string $originallyPurchasedAt): void
    {
        $this->originallyPurchasedAt = $originallyPurchasedAt;
    }

    /**
     * @param bool $renewStatus
     * @return void
     */
    public function setRenewStatus(bool $renewStatus): void
    {
        $this->renewStatus = $renewStatus;
    }

    /**
     * @param ?string $expiresAt
     * @return void
     */
    public function setExpiresAt(?string $expiresAt): void
    {
        $this->expiresAt = $expiresAt;
    }

    /**
     * @return array
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
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
