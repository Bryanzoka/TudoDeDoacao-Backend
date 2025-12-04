<?php

namespace App\Domain\Entities;

class PendingDonation
{
    private int $donationId;
    private int $userId;

    private function __construct(int $donationId, int $userId)
    {
        $this->donationId = $donationId;
        $this->userId = $userId;
    }

    public static function create(int $donationId, int $userId)
    {
        return new self($donationId, $userId);
    }

    public function update(int $donationId, int $userId)
    {
        $this->donationId = $donationId;
        $this->userId = $userId;
    }

    public static function restore(int $donationId, int $userId)
    {
        return new self($donationId, $userId);
    }
    
    public function getDonationId()
    {
        return $this->donationId;
    }

    public function getUserId()
    {
        return $this->userId;
    }
}