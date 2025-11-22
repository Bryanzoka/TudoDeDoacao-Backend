<?php

namespace App\Domain\Entities;

use DateTimeImmutable;

class VerificationCode 
{
    private readonly string $email;
    private readonly string $code;
    private DateTimeImmutable $expiresAt;

    private function __construct(string $email, string $code, DateTimeImmutable $expiresAt)
    {
        $this->email = $email;
        $this->code = $code;
        $this->expiresAt = $expiresAt;
    }

    public static function create(string $email)
    {
        $code = rand(100000, 999999);
        return new self($email, $code, new DateTimeImmutable('+10 Minutes'));
    }

    public static function restore(string $email, string $code, DateTimeImmutable $expiresAt)
    {
        return new self($email, $code, $expiresAt);
    }

    public function isExpired()
    {
        return $this->expiresAt < new DateTimeImmutable();
    }

    public function validateCode(string $code)
    {
        return $code == $this->code;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getExpiresAt()
    {
        return $this->expiresAt;
    }
}
