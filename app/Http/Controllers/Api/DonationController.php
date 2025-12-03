<?php

namespace App\Http\Controllers\Api;

use App\Application\Dtos\Donations\CreateDonationDto;
use App\Application\Dtos\Donations\GetFilteredDonationDto;
use App\Application\UseCases\Donations\GetFiltered;
use App\Application\UseCases\Donations\Update;
use App\Application\UseCases\Donations\Delete;
use App\Application\Dtos\Donations\UpdateDonationDto;
use App\Application\UseCases\Donations\CreateDonation;
use App\Application\UseCases\Donations\GetById;
use App\Application\UseCases\Donations\GetByUserId;
use App\Domain\Models\Donation;
use App\Application\UseCases\Donations\GetAll;
use App\Http\Controllers\Controller;
use App\Http\Requests\Donations\DonationStoreRequest;
use App\Http\Requests\Donations\DonationUpdateRequest;
use App\Http\Requests\Donations\GetFilteredRequest;
use App\Http\Resources\DonationResource;
use Exception;

class DonationController extends Controller
{

    public function index(GetAll $useCase)
    {
        try {
            $donations = $useCase->handle();
            return response()->json(['donations' => DonationResource::collection($donations)], 200);
        } catch(Exception $ex) {
            return response()->json($ex->getMessage(), $ex->getCode());
        }
    }

    public function store(DonationStoreRequest $request, CreateDonation $useCase)
    {
        $data = $request->validated();
        try {
            $id = $useCase->handle(CreateDonationDto::create(
                $data['user_id'],
                auth()->id(),
                $data['name'],
                $data['description'] ?? null,
                $data['category'],
                $request->image ?? null,
                $data['location']
            ));

            return response()->json(['id' => $id], 201);
        } catch(Exception $ex) {
            return response()->json($ex->getMessage(), $ex->getCode());
        }
    }

    public function show(int $id, GetById $useCase)
    {
        try {
            return response()->json(['donation' => new DonationResource($useCase->handle($id))], 200);
        } catch (Exception $ex) {
            return response()->json($ex->getMessage(), $ex->getCode());
        }
    }

    //Insert _method = PATCH in form-data POST requests to update the image and its other attributes
    public function update(DonationUpdateRequest $request, int $id, Update $useCase)
    {
        $data = $request->validated();
        try {
            $useCase->handle(UpdateDonationDto::create(
                $id,
                auth()->id(),
                $data['name'] ?? null,
                $data['description'] ?? null,
                $data['category'] ?? null,
                $request->image ?? null,
                $data['location'] ?? null,
                $data['status'] ?? null
            ));

            return response()->json(null, 204);
        } catch (Exception $ex) {
            return response()->json($ex->getMessage(), $ex->getCode());
        }
    }

    public function getFiltered(GetFilteredRequest $request, GetFiltered $useCase)
    {
        $request->validated();
        try {
            $donations = $useCase->handle(GetFilteredDonationDto::create(
                $request->query('name') ?? null,
                $request->query('category') ?? null,
                $request->query('location') ?? null,
                $request->query('status') ?? null,
                $request->query('limit', 30),
                $request->query('offset', 0),
            ));

            return response()->json(['donations' => DonationResource::collection($donations)], 200);
        } catch (Exception $ex) {
            return response()->json($ex->getMessage(), $ex->getCode());
        }
    }

    public function getByUser(int $userId, GetByUserId $useCase)
    {
        try {
            return response()->json(['donation' => new DonationResource($useCase->handle($userId))], 200);
        } catch (Exception $ex) {
            return response()->json($ex->getMessage(), $ex->getCode());
        }
    }

    public function getByName($name)
    {
        $firstWord = explode(' ', $name)[0];
        $donations = Donation::where('search_name', 'like', '%' . strtolower($firstWord) . '%')->get();

        if ($donations->isEmpty()) {
            return response()->json(['message' => 'no donations found with this name'], 404);
        }

        return DonationResource::collection($donations);
    }

    public function getByCategory($category)
    {
        $donations = Donation::where('category', '=', $category)->get();

        if ($donations->isEmpty()) {
            return response()->json(['message'=> 'no donations found with this category'],404);
        }

        return DonationResource::collection($donations);
    }

    public function getByLocation($location)
    {
        $donations = Donation::where('location', '=', $location)->get();

        if ($donations->isEmpty()) {
            return response()->json(['message'=> 'no donations found for this location'],404);
        }

        return DonationResource::collection($donations);
    }

    public function getByMyLocation()
    {
        $user = auth()->user();
        $donations = Donation::where('location', '=', $user->location)->where('user_id', '!=', $user->id)->get();

        if ($donations->isEmpty()) {
            return response()->json(['message'=> 'no donations found for your location'],404);
        }

        return DonationResource::collection($donations);
    }

    public function getMyDonations()
    {
        $user = auth()->user();
        $donations = Donation::where('user_id', '=', $user->id)->get();

        if ($donations->isEmpty()) {
            return response()->json(['message' => 'donations not found'], 404);
        }

        return DonationResource::collection($donations);
    }
    
    public function destroy(int $id, Delete $useCase)
    {
        try {
            $useCase->handle($id, auth()->id());
            return response()->json(null, 204);
        } catch (Exception $ex) {
            return response()->json($ex->getMessage(), $ex->getCode());
        }
    }
}
