<?php

namespace app\Infrastructure\Repositories;

use App\Domain\Entities\PendingDonation;
use App\Domain\Repositories\IPendingDonationRepository;
use App\Infrastructure\Models\PendingDonationModel;

class PendingDonationRepository implements IPendingDonationRepository
{
    public function create(PendingDonation $pendingDonation): int
    {
        return PendingDonationModel::create([
            'donation_id' => $pendingDonation->getDonationId(),
            'user_id' => $pendingDonation->getUserId(),
        ])->id;
    }

    public function delete(PendingDonation $pendingDonation): void
    {
        PendingDonationModel::where('user_id', '=', $pendingDonation->getUserId())->delete();
    }
}
