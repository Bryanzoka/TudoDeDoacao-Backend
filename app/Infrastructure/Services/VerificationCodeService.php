<?php

namespace App\Infrastructure\Services;

use App\Application\Contracts\IVerificationCodeService;
use App\Domain\Models\verificationCode;
use App\Domain\Repositories\IVerificationCodeRepository;

class VerificationCodeService implements IVerificationCodeService
{
    private readonly IVerificationCodeRepository $codeRepository;

    public function __construct(IVerificationCodeRepository $codeRepository)
    {
        $this->codeRepository = $codeRepository;
    }

    public function getByEmail(string $email)
    {
       return $this->codeRepository->getByEmail($email);
    }

    public function generateAndSave(string $email)
    {
        $this->codeRepository->deleteByEmail($email);
        $verification = verificationCode::generateCodeForEmail($email);
        return $this->codeRepository->save($verification);
    }

    public function validate(string $email, string $code)
    {
        $verification = verificationCode::where('email', $email)->first();

        $verification->validateCode($code);
    }

    public function delete(string $email)
    {
        $this->codeRepository->delete($this->getByEmail($email));
    }
}
