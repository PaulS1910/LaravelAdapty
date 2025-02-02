<?php
declare(strict_types=1);

namespace PS\LaravelAdapty\DTO;

class AccessLevel implements \JsonSerializable
{
    private ?string $startsAt;

    private ?string $expiresAt;

    private ?string $revokeAt;

    /**
     * @param string $accessLevelId
     */
    public function __construct(private string $accessLevelId) {
        if (empty($accessLevelId)) {
            throw new \InvalidArgumentException("accessLevelId can not be empty");
        }
    }

    /**
     * @param ?string $startsAt
     * @return void
     */
    public function setStartsAt(?string $startsAt):  void
    {
        $this->startsAt = $startsAt;
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
     * @param ?string $revokeAt
     * @return void
     */
    public function setRevokeAt(?string $revokeAt): void
    {
        $this->revokeAt = $revokeAt;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return array_filter([
            'access_level_id' => $this->accessLevelId ?? null,
            'starts_at' => $this->startsAt ?? null,
            'expires_at' => $this->expiresAt ?? null,
            'revoke_at' => $this->revokeAt ?? null,
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