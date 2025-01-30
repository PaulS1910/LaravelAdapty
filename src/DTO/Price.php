<?php
declare(strict_types=1);

namespace PS\LaravelAdapty\DTO;

class Price implements \JsonSerializable
{
    /**
     * @param string $country
     * @param string $currency
     * @param float $value
     */
    public function __construct(
        public readonly string $country,
        public readonly string $currency,
        public readonly float $value,
    ) {
        $values = array(
            $this->country, 
            $this->currency, 
            $this->value
        );
        foreach ($values as $value) {
            if (empty($value)) {
                throw new \InvalidArgumentException("Price properties can not be empty");
            }
        }
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return array_filter([
            'country' => $this->country,
            'currency' => $this->currency,
            'value' => $this->value,
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