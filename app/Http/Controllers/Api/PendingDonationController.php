<?php

namespace App\Http\Controllers\Api;

use App\Application\Dtos\Donations\CreatePendingDonationDto;
use App\Application\UseCases\Donations\UpdatePendingDonationUseCase;
use App\Application\UseCases\PendingDonations\CreatePendingDonation;
use App\Application\UseCases\PendingDonations\GetPendingDonationsByUserId;
use App\Application\UseCases\PendingDonations\GetPendingsByDonorId;
use App\Application\UseCases\PendingDonations\UpdatePendingDonation;
use App\Application\UseCases\PendingDonations\UpdatePendingDonationUseCase as PendingDonationsUpdatePendingDonationUseCase;
use App\Core\Domain\Donation\Dto\UpdatePendingDonationDto;
use App\Core\Domain\Donation\Dto\UpdatePendingDonationInputDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Donations\PendingDonationRequest;
use App\Http\Requests\Donations\PendingDonationUpdateRequest;
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

    public function update(PendingDonationUpdateRequest $request, int $donationId, UpdatePendingDonation $useCase)
    {
        $data = $request->validated();

        try {
            $ownerId = $request->user()->id;

            $sla = $useCase->handle(UpdatePendingDonationDto::create($donationId, $data['requesterId'], $data['status']));
            
            // $inputDto = (
            //     $donationId,
            //     $data['user_id'], // O usuário que solicitou a doação
            //     $ownerId, // O usuário logado (dono) que está aceitando/rejeitando
            //     $data['status']
            // );

            $outputDto = $this->useCase->handle($inputDto);
            return response()->json([
                'message' => 'Status da doação atualizado com sucesso.',
                'data' => (array) $outputDto
            ]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function store(PendingDonationRequest $request, CreatePendingDonation $useCase)
    {
        $data = $request->validated();
        try {
            $id = $useCase->handle(CreatePendingDonationDto::create(
                $data['user_id'],
                $data['donation_id']
            ));

            return response()->json(['id' => $id], 201);
        } catch (Exception $ex) {
            return response()->json($ex->getMessage(), $ex->getCode());
        }
    }

    public function destroy(int $donationId, Delete $useCase)
    {
        try {
            $useCase->handle($donationId);
            return response()->json(null, 204);
        } catch (Exception $ex) {
            return response()->json($ex->getMessage(), $ex->getCode());
        }
    }
}
