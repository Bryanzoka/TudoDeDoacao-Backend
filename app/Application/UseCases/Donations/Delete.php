<?php

namespace App\Application\UseCases\Donations;

use App\Domain\Repositories\IDonationRepository;
use Exception;
use Storage;

class Delete
{
    private readonly IDonationRepository $donationRepository;

    public function __construct(IDonationRepository $donationRepository)
    {
        $this->donationRepository = $donationRepository;
    }

    public function handle(int $id)
    {
        $donation = $this->donationRepository->getById($id) ?? throw new Exception('donation not found', 404);

        if ($donation->getImage()) {
            Storage::disk('public')->delete($donation->getImage());
        }

        $this->donationRepository->delete($donation);
    }
}