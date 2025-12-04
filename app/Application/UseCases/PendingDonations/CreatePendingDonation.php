<?php

namespace App\Application\UseCases\PendingDonations;

use App\Domain\Entities\PendingDonation;
use App\Domain\Repositories\IPendingDonationRepository;
use App\Domain\Repositories\IUserRepository;
use App\Application\Dtos\Donations\CreatePendingDonationDto;
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

        $pendingDonation = PendingDonation::create($dto->userId, $dto->donationId);

        return $this->pendingDonationRepository->create($pendingDonation);
    }
}
