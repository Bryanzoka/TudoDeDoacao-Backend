<?php

namespace App\Domain\Repositories;

use App\Domain\Models\Donation;

interface IDonationRepository
{
    public function findAll();
    public function save(array $data);
    public function findById();
    public function update();
    public function remove();
}