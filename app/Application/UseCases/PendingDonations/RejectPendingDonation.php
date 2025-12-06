<?php

namespace App\Application\UseCases\PendingDonations;

use App\Application\DTOs\PendingDonations\RejectPendingDonationDTO;
use App\Domain\Repositories\IDonationRepository;
use App\Domain\Repositories\IPendingDonationRepository;

class RejectPendingDonation
{
    public function __construct(
        private IDonationRepository $donationRepository,
        private IPendingDonationRepository $pendingDonationRepository
    ) {}

    public function handle(RejectPendingDonationDTO $dto): void
    {
        // 1. Validar se a doação existe e pertence ao usuário autenticado
        $donation = $this->donationRepository->getById($dto->getDonationId());

        if (!$donation) {
            throw new \Exception('Doação não encontrada');
        }

        if ($donation->getUserId() !== $dto->getDonorUserId()) {
            throw new \Exception('Você não é o dono desta doação');
        }

        // 2. Validar se o pedido existe
        if (!$this->pendingDonationRepository->exists($dto->getDonationId(), $dto->getRequesterId())) {
            throw new \Exception('Pedido não encontrado');
        }

        // 3. Remover APENAS este usuário específico da fila
        $this->pendingDonationRepository->deleteByDonationAndRequester(
            $dto->getDonationId(),
            $dto->getRequesterId()
        );

        // 4. Verificar se ainda existem outros pedidos pendentes
        $remainingRequests = $this->pendingDonationRepository->countByDonation($dto->getDonationId());

        // 5. Se a fila ficou vazia, volta o status para 'available'
        if ($remainingRequests === 0) {
            $this->donationRepository->updateStatus($dto->getDonationId(), 'available');
        }
        // Se ainda tem gente na fila, mantém 'pending' (não faz nada)
    }
}
