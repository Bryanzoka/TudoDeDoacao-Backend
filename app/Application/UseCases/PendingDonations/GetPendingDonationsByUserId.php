<?php

namespace App\Application\UseCases\PendingDonations;

use App\Domain\Repositories\IPendingDonationRepository;

class GetPendingDonationsByUserId
{
    private readonly IPendingDonationRepository $PendingDonationRepository;

    public function __construct(IPendingDonationRepository $PendingDonationRepository)
    {
        $this->PendingDonationRepository = $PendingDonationRepository;
    }

    public function handle(int $userId): array
    {
        return $this->PendingDonationRepository->getPendingDonationsByUserId($userId);
    }
}
