<?php

namespace App\Application\Dtos\Donations;

class AcceptedDonationDto
{
    public int $userId;
    public int $donationId;
    public string $userLocation;
    public string $donationLocation;

    private function __construct(int $userId, $donationId, $userLocation, $donationLocation)
    {
        $this->userId = $userId;
        $this->donationId = $donationId;
        $this->userLocation = $userLocation;
        $this->donationLocation = $donationLocation;
    }

    public static function create(int $userId, $donationId, $userLocation, $donationLocation)
    {
        return new self($userId, $donationId, $userLocation, $donationLocation);
    }
}