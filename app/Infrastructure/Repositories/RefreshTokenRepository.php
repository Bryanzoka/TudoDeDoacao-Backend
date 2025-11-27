<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\RefreshToken;
use App\Domain\Repositories\IRefreshTokenRepository;
use App\Infrastructure\Models\RefreshTokenModel;
use DateTimeImmutable;

class RefreshTokenRepository implements IRefreshTokenRepository
{
    public function getAll(int $user_id): array
    {
        return RefreshTokenModel::where('user_id', '=', $user_id)->orderBy('created_at', 'desc')->get()->map(fn($m) => RefreshToken::restore(
            $m->id,
            $m->user_id,
            $m->token,
            new DateTimeImmutable($m->expires_at)
        ));
    }

    public function getById(int $id): ?RefreshToken
    {
        $model = RefreshTokenModel::where('id', '=', $id)->first();

        if (!$model) {
            return null;
        }

        return RefreshToken::restore(
            $model->id,
            $model->user_id,
            $model->token,
            new DateTimeImmutable($model->expires_at)
        );
    }

    public function getByToken(string $token): ?RefreshToken
    {
        $model = RefreshTokenModel::where('token', '=', $token)->first();

        if (!$model) {
            return null;
        }

        return RefreshToken::restore(
            $model->id,
            $model->user_id,
            $model->token,
            new DateTimeImmutable($model->expires_at)
        );
    }

    public function create(RefreshToken $token): void
    {
        RefreshTokenModel::create([
            'user_id' => $token->getUserId(),
            'token' => $token->getToken(),
            'expires_at' => $token->getExpiresAt()
        ]);
    }

    public function delete(RefreshToken $token): void
    {
        RefreshTokenModel::where('id', '=', $token->getId())->delete();
    }
}