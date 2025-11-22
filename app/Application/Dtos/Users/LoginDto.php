<?php

namespace App\Application\Dtos\Users;

class LoginDto
{
    public string $email;
    public string $password;

    private function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public static function create(string $email, string $password)
    {
        return new self($email, $password);
    }
}