<?php

namespace App\Application\UseCases\Users;

use App\Application\Dtos\Users\UpdateUserDto;
use App\Domain\Repositories\IUserRepository;
use Exception;
use Storage;

class Update
{
    private readonly IUserRepository $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle(UpdateUserDto $dto)
    {
        $user = $this->userRepository->getById($dto->id) ?? throw new Exception('user not found', 404);

        $imagePath = $user->getProfileImage();

        if ($dto->profileImage) {
            if ($user->getProfileImage()) {
                Storage::disk('public')->delete($user->getProfileImage());    
            }

            $imagePath = $dto->profileImage->store('users', 'public');
        }

        $user->update(
            $dto->name ?? $user->getName(),
            $dto->email ?? $user->getEmail(),
            $dto->phone ?? $user->getPhone(),
            $imagePath,
            $dto->password ?? $user->getPassword(),
            $dto->location ?? $user->getLocation(),
        );

        $this->userRepository->update($user);
    }
}