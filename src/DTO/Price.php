<?php

declare(strict_types=1);

namespace PS\LaravelAdapty\DTO;

class Price implements \JsonSerializable
{
    /**
     * @param  string  $country  ISO 3166-1 alpha-2 country code, e.g. US
     * @param  string  $currency  ISO 4217 currency code, e.g. USD
     */
    public function __construct(
        public readonly string $country,
        public readonly string $currency,
        public readonly float $value,
    ) {
        $values = [
            $this->country,
            $this->currency,
            $this->value,
        ];
        foreach ($values as $value) {
            if (empty($value)) {
                throw new \InvalidArgumentException('Price properties can not be empty');
            }
        }
    }

    /**
     * @return array<string, mixed>
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
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
