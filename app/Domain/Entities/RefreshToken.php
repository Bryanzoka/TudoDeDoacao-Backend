<?php

namespace App\Domain\Entities;

use DateTimeImmutable;

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

    public static function create(?int $id, int $userId, string $token)
    {
        return new self($id, $userId, $token, new DateTimeImmutable('+7 days'));
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