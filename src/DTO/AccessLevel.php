<?php
declare(strict_types=1);

namespace PS\LaravelAdapty\DTO;

class AccessLevel implements \JsonSerializable
{
    private string|null $startsAt;

    private string|null $expiresAt;

    private string|null $revokeAt;

    /**
     * @param string $accessLevelId
     */
    public function __construct(private string $accessLevelId) {
        if (empty($accessLevelId)) {
            throw new \InvalidArgumentException("accessLevelId can not be empty");
        }
    }

    /**
     * @param string|null $startsAt
     * @return void
     */
    public function setStartsAt(?string $startsAt):  void
    {
        $this->startsAt = $startsAt;
    }

    /**
     * @param string|null $expiresAt
     * @return void
     */
    public function setExpiresAt(string $expiresAt): void
    {
        $this->expiresAt = $expiresAt;
    }

    /**
     * @param string|null $revokeAt
     * @return void
     */
    public function setRevokeAt(string $revokeAt): void
    {
        $this->revokeAt = $revokeAt;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return array_filter([
            'access_level_id' => $this->accessLevelId,
            'starts_at' => $this->startsAt,
            'expires_at' => $this->expiresAt,
            'revoke_at' => $this->revokeAt,
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