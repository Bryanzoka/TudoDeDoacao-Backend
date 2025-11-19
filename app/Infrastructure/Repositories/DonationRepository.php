<?php

namespace app\Infrastructure\Repositories;

use App\Domain\Models\Donation;
use App\Domain\Repositories\IDonationRepository;

class DonationRepository implements IDonationRepository
{
    public function getAll()
    {
        return Donation::all();
    }

    public function getById(int $id)
    {
        return Donation::where('id', '=', $id);
    }

    public function create(Donation $donation)
    {
       $donation->save();
       return $donation;
    }

    public function update(Donation $donation)
    {
        $donation->save();
        return $donation;
    }

    public function delete(Donation $donation)
    {
        $donation->delete();
    }
}