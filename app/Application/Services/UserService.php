<?php

namespace App\Application\Services;

use App\Application\Contracts\IUserService;
use App\Domain\Repositories\IUserRepository;
use App\Http\Resources\UserResource;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\UnauthorizedException;

class UserService implements IUserService
{
    private readonly IUserRepository $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAllUsers()
    {
        return UserResource::collection($this->userRepository->getAllUsers() ?? throw new Exception('users not found', 404));
    }

    public function getUserById(int $id, int $jwtUserId)
    {
        $this->validateUserAcess($id, $jwtUserId);
        return new UserResource($this->userRepository->getById($id) ?? throw new Exception('user not found', 404));
    }
    
    public function createUser(array $data)
    {
        if (isset($data['profile_image'])) {
            $data['profile_image'] = $data['profile_image']->store('users', 'public');
        }
        
        return new UserResource($this->userRepository->create($data));
    }

    public function updateUser(array $data, int $id, int $jwtUserId)
    {
        $this->validateUserAcess($id, $jwtUserId);
        $user = $this->getUserModelById($id);

        if (isset($data['profile_image'])) {
            if ($user->profile_image && Storage::disk('public')->exists($user->profile_image)) {
                Storage::disk('public')->delete($user->profile_image);
            }
            
            $data['profile_image'] = $data['profile_image']->store('users', 'public');
        }

        return new UserResource($this->userRepository->updateUser($user, $data));
    }

    public function deleteUser(int $id, int $jwtUserId)
    {
        $this->validateUserAcess($id, $jwtUserId);

        $user = $this->getUserModelById($id);

        return $this->userRepository->deleteUser($user);
    }

    private function validateUserAcess(int $id, int $jwtUserId)
    {
        if ($id != $jwtUserId) {
            throw new UnauthorizedException('invalid operation, login not matching', 401);
        }
    }

    private function getUserModelById(int $id)
    {
        return $this->userRepository->getById($id) ?? throw new Exception('user not found', 404);
    }
}