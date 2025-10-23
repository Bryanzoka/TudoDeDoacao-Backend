<?php

namespace App\Infrastructure\Services;

use App\Application\Contracts\IAuthService;
use App\Application\Contracts\IEmailService;
use App\Application\Contracts\IVerificationCodeService;
use App\Domain\Repositories\IUserRepository;
use Exception;

class AuthService implements IAuthService
{
    private readonly IUserRepository $userRepository;
    private readonly IEmailService $emailService;
    private readonly IVerificationCodeService $verificationService;
    public function __construct(IUserRepository $userRepository, IEmailService $emailService, IVerificationCodeService $verificationService)
    {
        $this->userRepository = $userRepository;
        $this->emailService = $emailService;
        $this->verificationService = $verificationService;
    }

    public function generateToken(array $credentials)
    {
        $user = $this->userRepository->getByEmail($credentials['email']);

        if (!$user || !$token = auth()->attempt($credentials)) {
            throw new Exception('invalid credentials', 401);
        }

        return $token;
    }

    public function logout()
    {
        auth()->logout();
    }

    public function requestVerificationCode(string $email)
    {
        $verification = $this->verificationService->generateAndSave($email);
        $this->emailService->send($email, 'verification code', "your verification code is $verification->code");
    }
}
