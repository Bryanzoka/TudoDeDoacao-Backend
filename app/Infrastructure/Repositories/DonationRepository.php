<?php

namespace app\Infrastructure\Repositories;

use App\Domain\Models\Donation;
use App\Domain\Repositories\IDonationRepository;
use App\Http\Resources\DonationResource;

class DonationRepository implements IDonationRepository
{
    public function findAll()
    {
        return Donation::all();
    }

    public function save(array $data)
    {
       Donation::create($data);
    }

    public function findById()
    {

    }

    public function update()
    {

    }

    public function remove()
    {
        
    }
}