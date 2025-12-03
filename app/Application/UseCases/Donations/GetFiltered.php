<?php

namespace App\Application\UseCases\Donations;

use App\Application\Dtos\Donations\GetFilteredDonationDto;
use App\Domain\Repositories\IDonationRepository;

class GetFiltered
{
    private readonly IDonationRepository $donationRepository;

    public function __construct(IDonationRepository $donationRepository)
    {
        $this->donationRepository = $donationRepository;
    }

    public function handle(GetFilteredDonationDto $dto)
    {
        $nameAscii = null;
        if ($dto->name) {
            $nameAscii = strtolower(iconv('UTF-8', 'ASCII//TRANSLIT', $dto->name));
        }

        return $this->donationRepository->getFiltered(
            $nameAscii, 
            strtolower($dto->category), 
            strtolower($dto->location),
            strtolower($dto->status),
            $dto->limit,
            $dto->offset
        );
    }
}