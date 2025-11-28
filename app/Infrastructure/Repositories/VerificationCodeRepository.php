<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Repositories\IVerificationCodeRepository;
use App\Domain\Entities\VerificationCode;
use App\Infrastructure\Models\VerificationCodeModel;
use DateTimeImmutable;

class VerificationCodeRepository implements IVerificationCodeRepository
{
    public function getByEmail(string $email)
    {
        $model = VerificationCodeModel::where('email', '=', $email)->first();

        if (!$model) {
            return null;
        }
        
        return VerificationCode::restore($model->email, $model->code, new DateTimeImmutable(($model->expires_at)));
    }

    public function save(VerificationCode $code)
    {
        VerificationCodeModel::create([
            'email' => $code->getEmail(),
            'code' => $code->getCode(),
            'expires_at' => $code->getExpiresAt()->format('Y-m-d H:i:s')
        ]);
    }

    public function delete(verificationCode $code)
    {
        return VerificationCodeModel::where('email', '=', $code->getEmail())->delete();
    }
}
