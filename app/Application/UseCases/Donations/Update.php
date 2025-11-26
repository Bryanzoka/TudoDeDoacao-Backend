<?php 

namespace App\Application\UseCases\Donations;

use App\Application\Dtos\Donations\UpdateDonationDto;
use App\Domain\Repositories\IDonationRepository;
use Exception;
use Storage;

class Update
{
    private readonly IDonationRepository $donationRepository;

    public function __construct(IDonationRepository $donationRepository)
    {
        $this->donationRepository = $donationRepository;
    }

    public function handle(UpdateDonationDto $dto)
    {
        $donation = $this->donationRepository->getById($dto->id) ?? throw new Exception('donation not found', 404);

        $imagePath = $donation->getImage();

        if ($dto->image) {
            if ($donation->getImage()) {
                Storage::disk('public')->delete($donation->getImage());
            }

            $imagePath = $dto->image->store('donations', 'public');
        }

        $donation->update($dto->name, $dto->description, $dto->category, $imagePath, $dto->location, $dto->status);

        $this->donationRepository->update($donation);
    }
}