<?php

namespace App\Http\Controllers\Api;

use App\Application\Dtos\Donations\CreatePendingDonationDto;
use App\Application\Dtos\PendingDonations\AcceptPendingDonationDTO;
use App\Application\DTOs\PendingDonations\RejectPendingDonationDTO;
use App\Application\UseCases\PendingDonations\CreatePendingDonation;
use App\Application\UseCases\PendingDonations\GetPendingDonationsByUserId;
use App\Application\UseCases\PendingDonations\GetPendingsByDonorId;
use App\Application\useCases\pendingDonations\AcceptPendingDonation;
use App\Application\UseCases\PendingDonations\RejectPendingDonation;
use App\Http\Controllers\Controller;
use App\Http\Requests\Donations\PendingDonationRequest;

use Exception;

class PendingDonationController extends Controller
{

    public function GetUserPendingDonations(int $userId, GetPendingDonationsByUserId $useCase)
    {
        $donation = $useCase->handle($userId);
        return response()->json(['solicitante_id' => $userId, 'donation' => $donation]);
    }

    public function getPendingsReceived(int $donorId, GetPendingsByDonorId  $useCase)
    {
        // O $userId aqui é o User 2 (Dono/Doador)
        $donations = $useCase->handle($donorId);

        return response()->json([
            'donor_id' => $donorId,
            'donations' => $donations
        ]);
    }

    public function accept(int $donationId, int $requesterId, AcceptPendingDonation $useCase)
    {
        try {
            $dto = new AcceptPendingDonationDTO($donationId, $requesterId, auth()->id());
            $useCase->handle($dto);
            return response()->json(['success' => true, 'message' => "Pedido de doação aceito com sucesso!"], 200);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'error' => $ex->getMessage()
            ], 400);
        }
    }

    public function store(PendingDonationRequest $request, CreatePendingDonation $useCase)
    {
        $data = $request->validated();

        try {
            $id = $useCase->handle(CreatePendingDonationDto::create(
                $data['requester_id'],
                $data['donation_id']
            ));

            return response()->json(['id' => $id], 201);
        } catch (Exception $ex) {
            return response()->json($ex->getMessage(), $ex->getCode());
        }
    }

    public function reject(int $donationId, int $requesterId, RejectPendingDonation $useCase)
    {
        try {
            $dto = new RejectPendingDonationDTO(
                $donationId,
                $requesterId,
                auth()->id()
            );

            $useCase->handle($dto);

            return response()->json([
                'success' => true,
                'message' => 'Pedido de doação rejeitado com sucesso!'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
