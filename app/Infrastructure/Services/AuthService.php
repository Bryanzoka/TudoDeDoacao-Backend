<?php

namespace App\Infrastructure\Services;

use App\Application\Contracts\IAuthService;
use App\Application\Contracts\IEmailService;
use App\Domain\Repositories\IUserRepository;
use Exception;
use Hoa\Math\Sampler\Random;

class AuthService implements IAuthService
{
    private readonly IUserRepository $userRepository;
    private readonly IEmailService $emailService;
    public function __construct(IUserRepository $userRepository, IEmailService $emailService)
    {
        $this->userRepository = $userRepository;
        $this->emailService = $emailService;
    }

    public function login(array $credentials)
    {
        $user = $this->userRepository->getByEmail($credentials['email']);

        if (!$user) {
            throw new Exception('invalid credentials', 401);
        }
        
        if (!$token = auth()->attempt($credentials)) {
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
        $code = rand(100000, 999999);
        $this->emailService->send($email, 'verification code', "your verification code is $code");
    }
}
