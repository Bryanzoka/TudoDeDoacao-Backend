<?php

namespace App\Application\Dtos\Users;

class LogoutDto
{
    public readonly string $token;

    private function __construct(string $token)
    {
        $this->token= $token;
    }

    public static function create(string $token)
    {
        return new self($token);
    }
}