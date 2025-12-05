<?php

namespace App\Domain\Entities;

class PendingDonation
{
    private int $userId;
    private int $donationId;

    private function __construct(int $userId, int $donationId)
    {
        $this->userId = $userId;
        $this->donationId = $donationId;
    }

    public static function create(int $userId, int $donationId)
    {
        return new self($userId, $donationId);
    }

    public function update(int $userId, int $donationId)
    {
        $this->userId = $userId;
        $this->donationId = $donationId;
    }

    public static function restore(int $userId, int $donationId)
    {
        return new self($userId, $donationId);
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
