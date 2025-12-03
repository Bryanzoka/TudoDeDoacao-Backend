<?php

namespace App\Application\UseCases\Donations;

use App\Domain\Entities\PendingDonation;
use App\Domain\Repositories\IDonationRepository;
use App\Domain\Repositories\IPendingDonationRepository;
use App\Domain\Repositories\IUserRepository;
use CreatePendingDonationDto;


class CreatePendingDonation
{
    private readonly IPendingDonationRepository $pendingDonationRepository;

    public function __construct(IPendingDonationRepository $pendingDonationRepository)
    {
        $this->pendingDonationRepository = $pendingDonationRepository;
    }

    public function handle(CreatePendingDonationDto $dto): int
    {
        $pendingDonation = PendingDonation::create($dto->donationId, $dto->userId );

        return $this->pendingDonationRepository->create($pendingDonation);
    }
}
