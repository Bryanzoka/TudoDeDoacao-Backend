<?php 

namespace App\Application\UseCases\Donations;

use App\Application\Dtos\Donations\UpdateDonationDto;
use App\Domain\Repositories\IDonationRepository;
use App\Domain\Repositories\IPendingDonationRepository;
use CreatePendingDonationDto;
use Exception;
use Storage;

class Update
{
    private readonly IPendingDonationRepository $pendingDonationRepository;

    public function __construct(IPendingDonationRepository $pendingDonationRepository)
    {
        $this->pendingDonationRepository = $pendingDonationRepository;
    }

    public function handle(CreatePendingDonationDto $dto)
    {

        $pendingDonation->update($dto->userId, $dto->donationId);

        $this->pendingDonationRepository->update($pendingDonation);
    }
}