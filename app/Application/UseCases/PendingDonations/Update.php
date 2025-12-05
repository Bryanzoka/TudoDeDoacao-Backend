<?php 

namespace App\Application\UseCases\Donations;

use App\Domain\Repositories\IPendingDonationRepository;
use App\Domain\Repositories\IUserRepository;
use CreatePendingDonationDto;
use Exception;
use Storage;

class Update
{
    private readonly IPendingDonationRepository $pendingDonationRepository;
    private readonly IUserRepository $userRepository;

    public function __construct(IPendingDonationRepository $pendingDonationRepository, IUserRepository $userRepository)
    {
        $this->pendingDonationRepository = $pendingDonationRepository;
        $this->userRepository = $userRepository;
    }
}