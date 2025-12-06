<?php

namespace App\application\UseCases\PendingDonations;

use App\Application\Dtos\PendingDonations\AcceptPendingDonationDTO;
use App\Infrastructure\Repositories\DonationRepository;
use App\Infrastructure\Repositories\PendingDonationRepository;
use Exception;

class AcceptPendingDonation
{
    public function __construct(
        private DonationRepository $donationRepository,
        private PendingDonationRepository $pendingDonationRepository
    ) {}

    public function handle(AcceptPendingDonationDTO $dto): void
    {
        // 1. Validar se a doação existe e pertence ao usuário autenticado
        $donation = $this->donationRepository->getById($dto->getDonationId());

        if (!$donation) {
            throw new Exception("donation not found");
        }

        if ($donation->getUserId() !== $dto->getDonorUserId()) {
            throw new Exception('Você não é o dono desta doação');
        }

        // 2. Validar se o pedido existe
        if (!$this->pendingDonationRepository->exists($dto->getDonationId(), $dto->getRequesterId())) {
            throw new Exception('Pending donation not found');
        }

        // 3. Atualizar status da donation para 'accepted'
        $this->donationRepository->updateStatus($dto->getDonationId(), 'accepted');

        // 4. Remover TODOS os pedidos pendentes dessa doação
        $this->pendingDonationRepository->deleteAllByDonation($dto->getDonationId());

        // 5. Opcional: Criar registro de doação confirmada
        // $this->confirmedDonationRepository->create($dto->getDonationId(), $dto->getAcceptedRequesterId());
    }
}
