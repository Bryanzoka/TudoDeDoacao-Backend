<?php

namespace App\Application\UseCases\PendingDonations;

use App\Domain\Repositories\IPendingDonationRepository;

class GetPendingsByDonorId
{
    private readonly IPendingDonationRepository $PendingDonationRepository;

    public function __construct(IPendingDonationRepository $PendingDonationRepository)
    {
        $this->PendingDonationRepository = $PendingDonationRepository;
    }

    public function handle(int $donorId): array
    {
        return $this->PendingDonationRepository->getReceivedPendingsByDonorId($donorId);
    }
}
