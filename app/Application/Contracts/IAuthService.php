<?php

namespace App\Application\Contracts;

interface IAuthService
{
    public function login(array $credentials);
    public function logout();
    public function requestVerificationCode(string $email);
}
