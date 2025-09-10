<?php

namespace App\Application\Services;

use App\Application\Contracts\IUserService;
use App\Domain\Repositories\IUserRepository;
use App\Http\Resources\UserResource;
use Exception;
use Illuminate\Support\Facades\Storage;

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

    public function getUserById(int $id)
    {
        return new UserResource($this->userRepository->getById($id) ?? throw new Exception('user not found', 404));
    }

    public function createUser(array $data)
    {
        if (isset($data['profile_image'])) {
            $data['profile_image'] = $data['profile_image']->store('users', 'public');
        }
        
        return new UserResource($this->userRepository->create($data));
    }

    public function updateUser(array $data, int $id)
    {
        $user = $this->getUserModelById($id);

        if (isset($data['profile_image'])) {
            if ($user->profile_image && Storage::disk('public')->exists($user->profile_image)) {
                Storage::disk('public')->delete($user->profile_image);
            }
            
            $data['profile_image'] = $data['profile_image']->store('users', 'public');
        }

        return new UserResource($this->userRepository->updateUser($user, $data));
    }

    private function getUserModelById(int $id)
    {
        return $this->userRepository->getById($id) ?? throw new Exception('user not found');
    }
}