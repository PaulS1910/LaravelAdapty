<?php

declare(strict_types=1);

namespace PS\LaravelAdapty\DTO;

class Offer implements \JsonSerializable
{
    /**
     * @param  string  $offerCategory  introductory, promotional, offer_code or win_back
     * @param  string  $offerType  free_trial, pay_as_you_go or pay_up_front
     */
    public function __construct(
        public readonly string $offerCategory,
        public readonly string $offerType,
        public readonly ?string $offerId,
    ) {
        $values = [
            $this->offerCategory,
            $this->offerType,
        ];
        foreach ($values as $value) {
            if (empty($value)) {
                throw new \InvalidArgumentException('Offer properties can not be empty');
            }
        }
    }

    public function setOfferID(?string $offerId): void
    {
        $this->offerId = $offerId;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_filter([
            'offer_category' => $this->offerCategory,
            'offer_type' => $this->offerType,
            'offer_id' => $this->offerId ?? null,
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
