<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\PendingDonation;
use App\Domain\Repositories\IPendingDonationRepository;
use App\Infrastructure\Models\PendingDonationModel;

class PendingDonationRepository implements IPendingDonationRepository
{

    public function getReceivedPendingsByDonorId(int $donorId): array
    {
        return PendingDonationModel::query()
            // 1. Carrega os dados da Doação (o item que foi solicitado)
            ->with('donation')
            // 2. Carrega os dados do Usuário (o solicitante)
            ->with('user')

            // 3. Filtra: Onde a Doação (relacionamento 'donation')
            //    tem o campo 'user_id' (o criador) igual ao $donorId
            ->whereHas('donation', function ($query) use ($donorId) {
                // Aqui estamos dentro da tabela 'donations'
                $query->where('user_id', $donorId);
            })->get()->toArray();
    }

    public function getPendingDonationsByUserId(int $requesterId): array
    {
        return PendingDonationModel::query()->where('requester_id', $requesterId)->with('donation')->with('user')->get()->toArray();
    }

    public function exists(int $donationId, string $requesterId)
    {
        return PendingDonationModel::where('donation_id', $donationId)
            ->where('requester_id', $requesterId)
            ->exists();
    }

    public function create(PendingDonation $pendingDonation): int
    {
        return PendingDonationModel::create([
            'donation_id' => $pendingDonation->getDonationId(),
            'requester_id' => $pendingDonation->getRequesterId(),
        ])->id;
    }

    public function deleteAllByDonation(int $donationId)
    {
        PendingDonationModel::where('donation_id', $donationId)->delete();
    }

    public function deleteByDonationAndRequester(int $donationId, int $requesterId)
    {
        PendingDonationModel::where('donation_id', $donationId)
            ->where('requester_id', $requesterId)
            ->delete();
    }

    public function countByDonation(int $donationId): int
    {
        return PendingDonationModel::where('donation_id', $donationId)->count();
    }

    public function delete(PendingDonation $pendingDonation): void
    {
        PendingDonationModel::where('user_id', '=', $pendingDonation->getRequesterId())->delete();
    }
}
