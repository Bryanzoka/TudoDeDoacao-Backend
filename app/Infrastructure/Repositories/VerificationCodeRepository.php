<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Repositories\IVerificationCodeRepository;
use App\Domain\Models\verificationCode;

class VerificationCodeRepository implements IVerificationCodeRepository
{
    public function getByEmail(string $email)
    {
        return verificationCode::where('email', '=', $email);
    }

    public function save(verificationCode $code)
    {
        $code->save();
    }

    public function delete(verificationCode $code)
    {
        $code->delete();
    }
}
