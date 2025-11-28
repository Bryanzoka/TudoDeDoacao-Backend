<?php

namespace App\Application\UseCases\Donations;

use App\Domain\Repositories\IDonationRepository;
use App\Domain\Repositories\IUserRepository;
use Exception;
use Storage;

class Delete
{
    private readonly IDonationRepository $donationRepository;
    private readonly IUserRepository $userRepository;

    public function __construct(IDonationRepository $donationRepository, IUserRepository $userRepository)
    {
        $this->donationRepository = $donationRepository;
        $this->userRepository = $userRepository;
    }

    public function handle(int $id, int $authId)
    {
        $donation = $this->donationRepository->getById($id) ?? throw new Exception('donation not found', 404);

        if ($donation->getUserId() != $authId) {
            $user = $this->userRepository->getById($authId) ?? throw new Exception('user not found', 404);

            if ($user->getRole() != 'admin') {
                throw new Exception('invalid authorization', 403);
            }
        }
        
        if ($donation->getImage()) {
            Storage::disk('public')->delete($donation->getImage());
        }

        $this->donationRepository->delete($donation);
    }
}