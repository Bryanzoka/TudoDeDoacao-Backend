<?php

namespace App\Http\Controllers\Api;

use App\Application\Dtos\Donations\CreatePendingDonationDto;
use App\Application\UseCases\PendingDonations\CreatePendingDonation;
use App\Application\UseCases\PendingDonations\GetPendingDonationsByUserId;
use App\Application\UseCases\PendingDonations\GetPendingsByDonorId;
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
}
