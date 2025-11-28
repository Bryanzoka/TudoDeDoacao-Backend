<?php

namespace App\Application\UseCases\Users;

use App\Domain\Repositories\IDonationRepository;
use App\Domain\Repositories\IUserRepository;
use Exception;
use Storage;

class Delete
{
    private readonly IUserRepository $userRepository;
    private readonly IDonationRepository $donationRepository;

    public function __construct(IUserRepository $userRepository, IDonationRepository $donationRepository)
    {
        $this->userRepository = $userRepository;
        $this->donationRepository = $donationRepository;
    }

    public function handle(int $id)
    {
        $user = $this->userRepository->getById($id) ?? throw new Exception('user not found', 404);

        $donations = $this->donationRepository->getAllByUserId($user->getId());

        foreach ($donations as $donation) {
            if ($donation->getImage()) {
                Storage::disk('public')->delete($donation->getImage());
            }

            $this->donationRepository->delete($donation);
        }

        if ($user->getProfileImage()) {
            Storage::disk('public')->delete($user->getProfileImage());    
        }
        
        $this->userRepository->delete($user);
    }
}