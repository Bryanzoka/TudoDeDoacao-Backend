<?php

namespace App\Infrastructure\Services;

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

    public function getAll()
    {
        return UserResource::collection($this->userRepository->getAll() ?? throw new Exception('users not found', 404));
    }

    public function getById(int $id, int $jwtUserId)
    {
        $this->validateUserAcess($id, $jwtUserId);
        return new UserResource($this->userRepository->getById($id) ?? throw new Exception('user not found', 404));
    }
    
    public function create(array $data)
    {
        if (isset($data['profile_image'])) {
            $data['profile_image'] = $data['profile_image']->store('users', 'public');
        }
        
        return new UserResource($this->userRepository->create($data));
    }

    public function update(array $data, int $id, int $jwtUserId)
    {
        $this->validateUserAcess($id, $jwtUserId);
        $user = $this->getUserModelById($id);

        if (isset($data['profile_image'])) {
            if ($user->profile_image && Storage::disk('public')->exists($user->profile_image)) {
                Storage::disk('public')->delete($user->profile_image);
            }
            
            $data['profile_image'] = $data['profile_image']->store('users', 'public');
        }

        return new UserResource($this->userRepository->update($user, $data));
    }

    public function delete(int $id, int $jwtUserId)
    {
        $this->validateUserAcess($id, $jwtUserId);

        $user = $this->getUserModelById($id);

        return $this->userRepository->delete($user);
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