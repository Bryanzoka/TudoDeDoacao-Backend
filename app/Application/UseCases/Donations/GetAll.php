<?php

namespace App\Application\UseCases\Donations;

use App\Domain\Repositories\IDonationRepository;
use Exception;

class GetAll
{
    private readonly IDonationRepository $donationRepository;

    public function __construct(IDonationRepository $donationRepository)
    {
        $this->donationRepository = $donationRepository;
    }

    public function handle()
    {
        return $this->donationRepository->getAll() ?? throw new Exception('donations not found', 404);
    }
}