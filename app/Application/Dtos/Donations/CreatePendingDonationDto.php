<?php

namespace App\Application\Dtos\Donations;

class CreatePendingDonationDto
{
    public int $requesterId;
    public int $donationId;

    private function __construct(int $requesterId, int $donationId)
    {
        $this->requesterId = $requesterId;
        $this->donationId = $donationId;
    }

    public static function create(int $requesterId, int $donationId)
    {
        return new self($requesterId, $donationId);
    }
}
