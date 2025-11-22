<?php

namespace App\Application\UseCases\Users;

use App\Domain\Repositories\IUserRepository;
use Exception;

class GetById
{
    private readonly IUserRepository $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle(int $id)
    {
        return $this->userRepository->getById($id) ?? throw new Exception('user not found', 404);
    }
}