<?php

namespace App\Domain\Repositories;

use App\Domain\Models\verificationCode;

interface IVerificationCodeRepository
{
    public function getByEmail(string $email);
    public function save(array $code);
    public function delete(verificationCode $code);
}
