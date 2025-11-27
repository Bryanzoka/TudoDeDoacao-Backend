<?php

namespace App\Domain\Entities;

use DateTimeImmutable;
use Exception;

class RefreshToken
{
    private ?int $id;
    private int $userId;
    private string $token;
    private DateTimeImmutable $expiresAt;

    private function __construct(?int $id, int $userId, string $token, DateTimeImmutable $expiresAt)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->token = $token;
        $this->expiresAt = $expiresAt;
    }

    public static function create(int $userId)
    {
        return new self(null, $userId, bin2hex(random_bytes(64)), new DateTimeImmutable('+7 days'));
    }

    public function refresh()
    {
        if ($this->expiresAt < new DateTimeImmutable()) {
            throw new Exception('token expired');
        }

        return new self(null, $this->userId, bin2hex(random_bytes(64)), new DateTimeImmutable('+7 days'));
    }

    public static function restore(int $id, int $userId, string $token, DateTimeImmutable $expiresAt)
    {
        return new self($id, $userId, $token, $expiresAt);
    }

    public function isExpired()
    {
        return $this->expiresAt < new DateTimeImmutable();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function getExpiresAt()
    {
        return $this->expiresAt;
    }
}