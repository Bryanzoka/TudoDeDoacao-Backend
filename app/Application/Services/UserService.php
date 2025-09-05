<?php

namespace App\Application\Services;

use App\Application\Contracts\IUserService;
use App\Domain\Repositories\IUserRepository;
use App\Http\Resources\UserResource;
use Exception;

class UserService implements IUserService
{
    private readonly IUserRepository $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function createUser(array $data)
    {
        if (isset($data['profile_image'])) {
            $data['profile_image'] = $data['profile_image']->store('users', 'public');
        }
        
        return new UserResource($this->userRepository->create($data));
    }

    public function getUserById(int $id)
    {
        return new UserResource($this->userRepository->getById($id) ?? throw new Exception('user not found'));
    }
}