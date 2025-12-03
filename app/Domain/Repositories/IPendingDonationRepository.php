<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Donation;

interface IPendingDonationRepository
{
    public function create(int $userId, int $donationId): int;

    // metodo update aqui
}