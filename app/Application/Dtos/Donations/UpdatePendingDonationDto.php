<?php

namespace App\Core\Domain\Donation\Dto;

class UpdatePendingDonationDto
{
    public function __construct(
        public int $donationId,
        public int $requesterId, // O ID do usuário que pediu a doação
        public string $status       // 'accept' ou 'reject'
    ) {}

    public static function create(int $donationId, int $requesterId, string $status)
    {
        return new self($donationId, $requesterId, $status);
    }
}
