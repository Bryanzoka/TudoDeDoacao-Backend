<?php

namespace App\Application\Dtos\Users;

class VerificationCodeDto
{
    public string $email;

    private function __construct(string $email)
    {
        $this->email = $email;
    }

    public static function create(string $email)
    {
        return new self($email);
    }
}