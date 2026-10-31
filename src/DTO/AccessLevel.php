<?php

declare(strict_types=1);

namespace PS\LaravelAdapty\DTO;

class AccessLevel implements \JsonSerializable
{
    private ?string $startsAt;

    private ?string $expiresAt;

    private ?string $revokeAt;

    /**
     * @param  string  $accessLevelId  Paid access level ID from the Access Levels page in the Adapty dashboard
     */
    public function __construct(private string $accessLevelId)
    {
        if (empty($accessLevelId)) {
            throw new \InvalidArgumentException('accessLevelId can not be empty');
        }
    }

    /**
     * @param  string|null  $startsAt  Datetime when access starts, can be in the future
     */
    public function setStartsAt(?string $startsAt): void
    {
        $this->startsAt = $startsAt;
    }

    /**
     * @param  string|null  $expiresAt  Datetime when access expires, can be in the past; null means lifetime access
     */
    public function setExpiresAt(?string $expiresAt): void
    {
        $this->expiresAt = $expiresAt;
    }

    /**
     * @param  string|null  $revokeAt  Datetime when access is revoked; null revokes immediately
     */
    public function setRevokeAt(?string $revokeAt): void
    {
        $this->revokeAt = $revokeAt;
    }

    /**
     * @return array<string, mixed>
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
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
