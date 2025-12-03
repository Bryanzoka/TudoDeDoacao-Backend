<?php

namespace app\Infrastructure\Repositories;

use App\Domain\Entities\PendingDonation;
use App\Domain\Repositories\IPendingDonationRepository;
use App\Infrastructure\Models\PendingDonationModel;

class PendingDonationRepository implements IPendingDonationRepository
{
    public function create(int $userId, int $donationId): int
    {
        return PendingDonationModel::create([
            'user_id' => $userId,
            'donation_id' => $donationId
        ])->id;
    }

     public function update(PendingDonation $pendingDonation): void
    {
        PendingDonationModel::update([
            'name' => $pendingDonation->getUserId(),
            'search_name' => $pendingDonation->getDonationId(),
        ]);
    }

}