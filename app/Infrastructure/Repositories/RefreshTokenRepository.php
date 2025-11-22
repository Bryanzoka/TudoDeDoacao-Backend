<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\RefreshToken;
use App\Domain\Repositories\IRefreshTokenRepository;
use App\Infrastructure\Models\RefreshTokenModel;

class RefreshTokenRepository implements IRefreshTokenRepository
{
    public function getAll(int $user_id)
    {
        return RefreshTokenModel::where('user_id', '=', $user_id)->orderBy('created_at', 'desc')->get();
    }

    public function getById(int $id)
    {
        return RefreshTokenModel::where('id', '=', $id)->first();
    }

    public function getByToken(string $token)
    {
        return RefreshTokenModel::where('token', '=', $token)->first();
    }

    public function create(RefreshToken $token)
    {
        return RefreshTokenModel::create([
            'user_id' => $token->getUserId(),
            'token' => $token->getToken(),
            'expires_at' => $token->getExpiresAt()
        ]);
    }

    public function delete(RefreshToken $token)
    {
        $model = $this->getById($token->getId());
        return $model->delete();
    }
}