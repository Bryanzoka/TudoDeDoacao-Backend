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

                $data['user_id'],
                $data['donation_id']
            ));

            return response()->json(['id' => $id], 201);
        } catch(Exception $ex) {
            return response()->json($ex->getMessage(), $ex->getCode());
        }
    }

    //Insert _method = PATCH in form-data POST requests to update
    public function update(PendingDonationRequest $request, int $id, Update $useCase)
    {
        $data = $request->validated();
        try {
            $useCase->handle(CreatePendingDonationDto::create(
               $data['user_id'],
               $data['donation_id']
            ));

            return response()->json(null, 204);
        } catch (Exception $ex) {
            return response()->json($ex->getMessage(), $ex->getCode());
        }
    }
}
