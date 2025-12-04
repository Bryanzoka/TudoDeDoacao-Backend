<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Donation;
use App\Domain\Entities\PendingDonation;

interface IPendingDonationRepository
{
    public function create(PendingDonation $pending): int;
    public function delete(PendingDonation $pending): void;
}