<?php

namespace App\Application\Contracts;

interface IVerificationCodeService
{
    public function getByEmail(string $email);
    public function generateAndSave(string $email);
    public function validate(string $email, string $code);
    public function delete(string $email);
}
