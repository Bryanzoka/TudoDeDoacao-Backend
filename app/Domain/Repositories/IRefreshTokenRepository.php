<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\RefreshToken;

interface IRefreshTokenRepository
{
    public function getAll(int $userId): array;
    public function getById(int $id): ?RefreshToken;
    public function getByToken(string $token): ?RefreshToken;
    public function create(RefreshToken $token): void;
    public function delete(RefreshToken $token): void;
}