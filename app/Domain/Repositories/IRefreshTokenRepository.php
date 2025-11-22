<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\RefreshToken;

interface IRefreshTokenRepository
{
    public function getAll(int $user_id);
    public function getById(int $id);
    public function getByToken(string $token);
    public function create(RefreshToken $token);
    public function delete(RefreshToken $token);
}