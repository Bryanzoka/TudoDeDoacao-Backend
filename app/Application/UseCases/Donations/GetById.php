<?php

namespace App\Application\UseCases\Donations;

use App\Domain\Repositories\IDonationRepository;
use Exception;

class GetById
{
    private readonly IDonationRepository $donationRepository;

    public function __construct(IDonationRepository $donationRepository)
    {
        $this->donationRepository = $donationRepository;
    }

    public function handle(int $id)
    {
        return $this->donationRepository->getById($id) ?? throw new Exception('donation not found', 404);
    }
}