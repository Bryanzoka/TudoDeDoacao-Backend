<?php

namespace App\Application\UseCases\Donations;

use App\Domain\Entities\PendingDonation;
use App\Domain\Repositories\IPendingDonationRepository;
use App\Domain\Repositories\IUserRepository;
use CreatePendingDonationDto;
use Exception;

class CreatePendingDonation
{
    private readonly IPendingDonationRepository $pendingDonationRepository;
    private readonly IUserRepository $userRepository;

    public function __construct(IPendingDonationRepository $pendingDonationRepository, IUserRepository $userRepository)
    {
        $this->pendingDonationRepository = $pendingDonationRepository;
        $this->userRepository = $userRepository;
    }

        public function handle(CreatePendingDonationDto $dto): int
        {

            if (!$this->userRepository->getById($dto->userId)) {
                throw new Exception('user does not exist', 400);
            }

            $pendingDonation = PendingDonation::create($dto->donationId, $dto->userId);

            return $this->pendingDonationRepository->create($pendingDonation);
        }
}
