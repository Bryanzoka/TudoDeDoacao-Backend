<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\PendingDonation;

interface IPendingDonationRepository
{
    public function getPendingDonationsByUserId(int $userId): array;
    public function getReceivedPendingsByDonorId(int $donorId): array;
    public function exists(int $donationId, string $requesterId);
    public function create(PendingDonation $pending): int;
    public function deleteAllByDonation(int $donationId);
    public function deleteByDonationAndRequester(int $donationId, int $requesterId);
    public function countByDonation(int $donationId): int;
    public function delete(PendingDonation $pending): void;
}
