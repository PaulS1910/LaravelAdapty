<?php

declare(strict_types=1);

namespace PS\LaravelAdapty\DTO;

class Profile implements \JsonSerializable
{
    private ?string $firstName;

    private ?string $lastName;

    private ?string $gender;

    private ?string $email;

    private ?string $phoneNumber;

    private string $birthday;

    private ?string $ipCountry;

    private ?string $storeCountry;

    private bool $analyticsDisabled;

    /** @var list<array{key: string, value: string|float}> */
    private array $customAttributes;

    /** @var array<string, string> */
    private array $installationMeta;

    public function __construct() {}

    public function setFirstName(?string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function setLastName(?string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @param  string|null  $gender  f, m or o
     */
    public function setGender(?string $gender): void
    {
        $this->gender = $gender;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function setPhoneNumber(?string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function setBirthday(string $birthday): void
    {
        $this->birthday = $birthday;
    }

    /**
     * @param  string|null  $ipCountry  ISO 3166-1 alpha-2 country code, e.g. US
     */
    public function setIpCountry(?string $ipCountry): void
    {
        $this->ipCountry = $ipCountry;
    }

    /**
     * @param  string|null  $storeCountry  ISO 3166-1 alpha-2 country code, e.g. US
     */
    public function setStoreCountry(?string $storeCountry): void
    {
        $this->storeCountry = $storeCountry;
    }

    public function setAnalyticsDisabled(bool $analyticsDisabled): void
    {
        $this->analyticsDisabled = $analyticsDisabled;
    }

    /**
     * @param  list<array{key: string, value: string|float}>  $customAttributes  Up to 30 items; key up to 30 characters
     *                                                                           (letters, digits, -._), value up to 50 characters
     */
    public function setCustomAttributes(array $customAttributes): void
    {
        $this->customAttributes = $customAttributes;
    }

    /**
     * @param  array<string, string>  $installationMeta  device_id is required, see the Adapty docs for the other keys
     */
    public function setInstallationMeta(array $installationMeta): void
    {
        $this->installationMeta = $installationMeta;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_filter([
            'first_name' => $this->firstName ?? null,
            'last_name' => $this->lastName ?? null,
            'gender' => $this->gender ?? null,
            'email' => $this->email ?? null,
            'phone_number' => $this->phoneNumber ?? null,
            'birthday' => $this->birthday ?? null,
            'ip_country' => $this->ipCountry ?? null,
            'store_country' => $this->storeCountry ?? null,
            'analytics_disabled' => $this->analyticsDisabled ?? null,
            'custom_attributes' => $this->customAttributes ?? null,
            'installation_meta' => $this->installationMeta ?? null,
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
