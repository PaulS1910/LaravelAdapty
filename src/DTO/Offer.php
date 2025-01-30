<?php
declare(strict_types=1);

namespace PS\LaravelAdapty\DTO;

class Offer implements \JsonSerializable
{
    /**
     * @param string $offerCategory
     * @param string $offerType
     * @param string $offerId
     */
    public function __construct(
        public readonly string $offerCategory,
        public readonly string $offerType,
        public readonly string $offerId,
    ) {
        $values = array(
            $this->offerCategory, 
            $this->offerType
        );
        foreach ($values as $value) {
            if (empty($value)) {
                throw new \InvalidArgumentException("Offer properties can not be empty");
            }
        }
    }

    /**
     * @param string|null $offerId
     * @return void
     */
    public function setFirstName(?string $offerId): void
    {
        $this->offerId = $offerId;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return array_filter([
            'offer_category' => $this->offerCategory,
            'offer_type' => $this->offerType,
            'offer_id' => $this->offerId,
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