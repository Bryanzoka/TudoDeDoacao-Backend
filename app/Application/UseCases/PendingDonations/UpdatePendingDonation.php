<?php

namespace App\Application\UseCases\PendingDonations;

use App\Core\Domain\Donation\Dto\UpdatePendingDonationDto;
use App\Domain\Repositories\IDonationRepository;
use App\Domain\Repositories\IPendingDonationRepository;
use App\Domain\Repositories\IUserRepository;
use App\Infrastructure\Repositories\DonationRepository;

class UpdatePendingDonation
{
    private readonly IPendingDonationRepository $pendingDonationRepository;
    private readonly IDonationRepository $donationRepository;
    private readonly IUserRepository $userRepository;

    public function __construct(IPendingDonationRepository $pendingDonationRepository, IDonationRepository $donationRepository, IUserRepository $userRepository)
    {
        $this->pendingDonationRepository = $pendingDonationRepository;
        $this->userRepository = $userRepository;
        $this->donationRepository = $donationRepository;
    }

    public function handle(UpdatePendingDonationDto $dto)
    {
        $donation = $this->donationRepository->getById($dto->donationId);
        $this->donationRepository->update($donation);
    }
}
