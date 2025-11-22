<?php

namespace App\Application\UseCases\Users;

use App\Application\Dtos\Users\LogoutDto;
use App\Domain\Repositories\IRefreshTokenRepository;
use Auth;

class Logout
{
    private readonly IRefreshTokenRepository $tokenRepository;

    public function __construct(IRefreshTokenRepository $tokenRepository)
    {
        $this->tokenRepository = $tokenRepository;
    }

    public function handle(LogoutDto $dto)
    {
        $token = $this->tokenRepository->getByToken($dto->token);
        $this->tokenRepository->delete($token);

        Auth()->logout();
    }
}