<?php

namespace App\Application\UseCases\Users;

use App\Application\Dtos\Users\LoginDto;
use App\Domain\Entities\RefreshToken;
use App\Domain\Repositories\IRefreshTokenRepository;
use App\Domain\Repositories\IUserRepository;
use Exception;

class Login
{
    private readonly IRefreshTokenRepository $tokenRepository;
    private readonly IUserRepository $userRepository;

    public function __construct(IRefreshTokenRepository $tokenRepository, IUserRepository $userRepository)
    {
        $this->tokenRepository = $tokenRepository;
        $this->userRepository = $userRepository;
    }

    public function handle(LoginDto $dto)
    {
        $user = $this->userRepository->getByEmail($dto->email) ?? throw new Exception('user not found with this email', 404);

        if (!$accessToken = auth()->attempt((array)$dto)) {
            throw new Exception('invalid credentials', 401);
        }

        $refreshToken = RefreshToken::create($user->getId());
        $this->tokenRepository->create($refreshToken);

        return [
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken->getToken()
        ];
    }
}