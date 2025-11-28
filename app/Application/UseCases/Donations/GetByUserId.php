<?php

namespace App\Application\UseCases\Donations;

use App\Domain\Repositories\IDonationRepository;
use Exception;

class GetByUserId
{
    private readonly IDonationRepository $donationRepository;

    public function __construct(IDonationRepository $donationRepository)
    {
        $this->donationRepository = $donationRepository;
    }

    public function handle(int $userId)
    {
        return $this->donationRepository->getByUserId($userId) ?? throw new Exception('donation not found', 404);
    }
}