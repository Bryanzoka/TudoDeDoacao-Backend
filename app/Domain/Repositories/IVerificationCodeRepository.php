<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\VerificationCode;

interface IVerificationCodeRepository
{
    public function getByEmail(string $email);
    public function save(VerificationCode $code);
    public function delete(VerificationCode $code);
}
