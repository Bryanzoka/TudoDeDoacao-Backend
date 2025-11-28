<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Donation;

interface IDonationRepository
{
    public function getAll(): array;
    public function getAllByUserId(int $userId): array;
    public function getById(int $id): ?Donation;
    public function getByUserId(int $userId): ?Donation;
    public function create(Donation $donation): int;
    public function update(Donation $donation): void;
    public function delete(Donation $donation): void;
}