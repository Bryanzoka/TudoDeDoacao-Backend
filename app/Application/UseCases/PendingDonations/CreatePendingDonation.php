<?php

namespace App\Application\UseCases\PendingDonations;

use App\Domain\Entities\PendingDonation;
use App\Domain\Repositories\IPendingDonationRepository;
use App\Domain\Repositories\IUserRepository;
use App\Application\Dtos\Donations\CreatePendingDonationDto;
use App\Domain\Repositories\IDonationRepository;
use Exception;

class CreatePendingDonation
{
    private readonly IPendingDonationRepository $pendingDonationRepository;
    private readonly IUserRepository $userRepository;
    private readonly IDonationRepository $donationRepository;

    public function __construct(IPendingDonationRepository $pendingDonationRepository, IDonationRepository $donationRepository, IUserRepository $userRepository)
    {
        $this->pendingDonationRepository = $pendingDonationRepository;
        $this->userRepository = $userRepository;
        $this->donationRepository = $donationRepository;
    }

    public function handle(CreatePendingDonationDto $dto): int
    {
        if ($this->pendingDonationRepository->exists($dto->donationId, $dto->requesterId)) {
            throw new Exception('Você já solicitou esta doação', 400);
        }

        $pendingDonation = PendingDonation::create($dto->requesterId, $dto->donationId);

        $id = $this->pendingDonationRepository->create($pendingDonation);
        $this->donationRepository->updateStatus($dto->donationId, "pending");

        return $id;
    }
}
