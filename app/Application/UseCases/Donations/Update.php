<?php 

namespace App\Application\UseCases\Donations;

use App\Application\Dtos\Donations\UpdateDonationDto;
use App\Domain\Repositories\IDonationRepository;
use App\Domain\Repositories\IUserRepository;
use Exception;
use Storage;

class Update
{
    private readonly IDonationRepository $donationRepository;
    private readonly IUserRepository $userRepository;

    public function __construct(IDonationRepository $donationRepository, IUserRepository $userRepository)
    {
        $this->donationRepository = $donationRepository;
        $this->userRepository = $userRepository;
    }

    public function handle(UpdateDonationDto $dto)
    {
        $donation = $this->donationRepository->getById($dto->id) ?? throw new Exception('donation not found', 404);

        if ($donation->getUserId() != $dto->authId) {
            $user = $this->userRepository->getById($dto->authId) ?? throw new Exception('user not found');

            if ($user->getRole() != 'admin') {
                throw new Exception('invalid authorization', 403);
            }
        }
        
        $imagePath = $donation->getImage();

        if ($dto->image) {
            if ($donation->getImage()) {
                Storage::disk('public')->delete($donation->getImage());
            }

            $imagePath = $dto->image->store('donations', 'public');
        }

        $donation->update(
            $dto->name ?? $donation->getName(),
            $dto->description ?? $donation->getDescription(), 
            $dto->category ?? $donation->getCategory(), 
            $imagePath,
            $dto->location ?? $donation->getLocation(), 
            $dto->status ?? $donation->getStatus()
        );

        $this->donationRepository->update($donation);
    }
}