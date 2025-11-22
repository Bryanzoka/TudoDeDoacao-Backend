<?php

namespace App\Application\UseCases\Users;

use App\Domain\Repositories\IUserRepository;
use Exception;

class GetAll
{
    private readonly IUserRepository $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle()
    {
        return $this->userRepository->getAll() ?? throw new Exception('users not found', 404);
    }
}