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

    private array $customAttributes;

    private array $installationMeta;

    public function __construct() {
    }

    /**
     * @param ?string $firstName
     * @return void
     */
    public function setFirstName(?string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @param ?string $lastName
     * @return void
     */
    public function setLastName(?string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @param ?string $gender
     * @return void
     */
    public function setGender(?string $gender): void
    {
        $this->gender = $gender;
    }

    /**
     * @param ?string $email
     * @return void
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * @param ?string $phoneNumber
     * @return void
     */
    public function setPhoneNumber(?string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @param string $birthday
     * @return void
     */
    public function setBirthday(string $birthday): void
    {
        $this->birthday = $birthday;
    }

    /**
     * @param ?string $ipCountry
     * @return void
     */
    public function setIpCountry(?string $ipCountry): void
    {
        $this->ipCountry = $ipCountry;
    }

    /**
     * @param ?string $storeCountry
     * @return void
     */
    public function setStoreCountry(?string $storeCountry): void
    {
        $this->storeCountry = $storeCountry;
    }

    /**
     * @param bool $analyticsDisabled
     * @return void
     */
    public function setAnalyticsDisabled(bool $analyticsDisabled): void
    {
        $this->analyticsDisabled = $analyticsDisabled;
    }

    /**
     * @param array $customAttributes
     * @return void
     */
    public function setCustomAttributes(array $customAttributes): void
    {
        $this->customAttributes = $customAttributes;
    }

    /**
     * @param array $installationMeta
     * @return void
     */
    public function setInstallationMeta(array $installationMeta): void
    {
        $this->installationMeta = $installationMeta;
    }

    /**
     * @return array
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
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}