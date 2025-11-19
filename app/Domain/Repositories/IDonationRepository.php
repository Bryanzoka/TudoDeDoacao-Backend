<?php

namespace App\Domain\Repositories;

use App\Domain\Models\Donation;

interface IDonationRepository
{
    public function getAll();
    public function getById(int $id);
    public function create(Donation $donation);
    public function update(Donation $donation);
    public function delete(Donation $donation);
}