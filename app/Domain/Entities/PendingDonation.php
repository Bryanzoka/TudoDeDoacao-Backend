<?php

namespace App\Domain\Entities;

class PendingDonation
{
    private int $requesterId;
    private int $donationId;

    private function __construct(int $requesterId, int $donationId)
    {
        $this->requesterId = $requesterId;
        $this->donationId = $donationId;
    }

    public static function create(int $requesterId, int $donationId)
    {
        return new self($requesterId, $donationId);
    }

    public static function restore(int $requesterId, int $donationId)
    {
        return new self($requesterId, $donationId);
    }

    public function getDonationId()
    {
        return $this->donationId;
    }

    public function getRequesterId()
    {
        return $this->requesterId;
    }
}
