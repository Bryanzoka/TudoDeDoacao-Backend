<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Donation;

interface IDonationRepository
{
    public function getAll(): array;
    public function getAllByUserId(int $userId): array;
    public function getById(int $id): ?Donation;
    public function getByUserId(int $userId): ?Donation;
    public function getFiltered(?string $name, ?string $category, ?string $location, ?string $status, int $limit = 30, int $offset = 0): array;
    public function create(Donation $donation): int;
    public function update(Donation $donation): void;
    public function updateStatus(int $donationId, string $status): void;
    public function delete(Donation $donation): void;
}
