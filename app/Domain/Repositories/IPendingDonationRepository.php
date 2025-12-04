<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\PendingDonation;

interface IPendingDonationRepository
{
    public function getPendingDonationsByUserId(int $userId): array;
    public function getReceivedPendingsByDonorId(int $donorId): array;
    public function create(PendingDonation $pending): int;
    public function delete(PendingDonation $pending): void;
}
