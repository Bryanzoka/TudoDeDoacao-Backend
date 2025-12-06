<?php

namespace App\Application\UseCases\Donations;

use App\Application\Dtos\Donations\CreatePendingDonationDto;
use App\Domain\Entities\PendingDonation;
use App\Domain\Repositories\IPendingDonationRepository;
use App\Domain\Repositories\IUserRepository;
use Exception;

class RemoveSpecificPendingDonationRequest
{
    private readonly IPendingDonationRepository $pendingDonationRepository;
    private readonly IUserRepository $userRepository;

    public function __construct(IPendingDonationRepository $pendingDonationRepository, IUserRepository $userRepository)
    {
        $this->pendingDonationRepository = $pendingDonationRepository;
        $this->userRepository = $userRepository;
    }

    public function handle(CreatePendingDonationDto $dto)
    {
        if (!$this->userRepository->getById($dto->userId)) {
            throw new Exception('user does not exist', 400);
        }

        $pendingDonation = PendingDonation::restore($dto->userId, $dto->donationId);

        return $this->pendingDonationRepository->delete($pendingDonation);
    }
}
