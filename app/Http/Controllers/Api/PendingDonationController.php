<?php

namespace App\Http\Controllers\Api;

use App\Application\UseCases\Donations\CreatePendingDonation;
use App\Http\Controllers\Controller;
use App\Http\Requests\PendingDonationRequest;
use CreatePendingDonationDto;
use Exception;

class PendingDonationController extends Controller
{
   public function store(PendingDonationRequest $request, CreatePendingDonation $useCase)
    {
        $data = $request->validated();
        try {
            $id = $useCase->handle(CreatePendingDonationDto::create(
                $data['donation_id'],
                $data['user_id']
            ));

            return response()->json(['id' => $id], 201);
        } catch(Exception $ex) {
            return response()->json($ex->getMessage(), $ex->getCode());
        }
    }
}
