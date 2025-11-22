<?php

namespace App\Application\UseCases\Users;

use App\Domain\Repositories\IUserRepository;
use Exception;
use Storage;

class Delete
{
    private readonly IUserRepository $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle(int $id)
    {
        $user = $this->userRepository->getById($id) ?? throw new Exception('user not found', 404);

        if ($user->getProfileImage()) {
            Storage::disk('public')->delete($user->getProfileImage());    
        }
        
        $this->userRepository->delete($user);
    }
}