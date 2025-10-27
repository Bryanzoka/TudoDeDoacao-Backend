<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Repositories\IVerificationCodeRepository;
use App\Domain\Models\verificationCode;

class VerificationCodeRepository implements IVerificationCodeRepository
{
    public function getByEmail(string $email)
    {
        return verificationCode::where('email', $email)->first();
    }

    public function save(array $code)
    {
        return verificationCode::create($code);
    }

    public function delete(verificationCode $code)
    {
        $code->delete();
    }

    public function deleteByEmail(string $email)
    {
        verificationCode::where('email', $email)->delete();
    }
}
