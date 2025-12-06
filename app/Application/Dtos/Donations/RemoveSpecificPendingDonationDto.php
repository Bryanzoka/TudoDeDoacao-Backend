<?php

namespace App\Application\Dtos\Donations;

class RemoveSpecificPendingDonationDto
{
    public int $userId;
    public int $donationId;

    private function __construct(int $userId, int $donationId)
    {
        $this->userId = $userId;
        $this->donationId = $donationId;
    }

    public static function remove(int $userId, int $donationId)
    {
        return new self($userId, $donationId);
    }
}
