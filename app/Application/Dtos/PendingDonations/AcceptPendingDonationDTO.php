<?php

namespace App\Application\Dtos\PendingDonations;

class AcceptPendingDonationDTO
{
    public function __construct(
        private int $donationId,
        private int $requesterId,
        private int $donorUserId
    ) {}

    public function getDonationId(): int
    {
        return $this->donationId;
    }

    public function getRequesterId(): int
    {
        return $this->requesterId;
    }

    public function getDonorUserId(): int
    {
        return $this->donorUserId;
    }
}
