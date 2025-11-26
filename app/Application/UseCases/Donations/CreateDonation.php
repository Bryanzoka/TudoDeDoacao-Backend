<?php

namespace App\Application\UseCases\Donations;

use App\Application\Dtos\Donations\CreateDonationDto;
use App\Domain\Entities\Donation;
use App\Domain\Repositories\IDonationRepository;
use App\Domain\Repositories\IUserRepository;
use Exception;

class CreateDonation
{
    private readonly IDonationRepository $donationRepository;
    private readonly IUserRepository $userRepository;

    public function __construct(IDonationRepository $donationRepository, IUserRepository $userRepository)
    {
        $this->donationRepository = $donationRepository;
        $this->userRepository = $userRepository;
    }

    public function handle(CreateDonationDto $dto): int
    {
        if (!$this->userRepository->getById($dto->userId)) {
            throw new Exception('user does not exist', 400);
        }

        $imagePath = null;

        if ($dto->image) {
            $imagePath = $dto->image->store('donations', 'public');
        }

        $donation = Donation::create($dto->userId, $dto->name, $dto->description, $dto->category, $imagePath, $dto->location);

        return $this->donationRepository->create($donation);
    }
}