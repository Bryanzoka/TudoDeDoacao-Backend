<?php

namespace App\Http\Controllers\Api;

use app\Application\Contracts\IDonationService;
use App\Domain\Models\Donation;
use App\Http\Controllers\Controller;
use App\Http\Requests\DonationRequests\DonationRequest;
use App\Http\Requests\DonationRequests\DonationUpdateRequest;
use App\Http\Resources\DonationResource;
use Exception;
use Illuminate\Support\Facades\Storage;

class DonationController extends Controller
{
    private readonly IDonationService $donationService;

    public function __construct(IDonationService $donationService)
    {
        $this->donationService = $donationService;
    }

    public function index()
    {
        try {
            $donations = $this->donationService->getAll(); 
            return response()->json(['donations'=> $donations], 200);
        } catch(Exception $ex) {
            return response()->json($ex->getMessage(), $ex->getCode());
        }
    }

    public function store(DonationRequest $request)
    {
        try {
            $res = $this->donationService->create($request->validated());
            return response()->json(['donation' => $res], 201);
        } catch(Exception $ex) {
            return response()->json($ex->getMessage(), $ex->getCode());
        }
        // $donation = Donation::create($data);
        // $donation->search_name = strtolower(str::ascii($donation->name));
        // $donation->save();
        // return new DonationResource($donation);
    }

    public function show(Donation $donation)
    {
        return new DonationResource($donation);
    }

    //Insert _method = PATCH in form-data POST requests to update the image and its other attributes
    public function update(DonationUpdateRequest $request, Donation $donation)
    {
        if (auth()->id() != $donation->user_id) {
            return response()->json(['message' => 'invalid operation, mismatched credentials'], 401);
        }

        $donation = $this->donationService->update($request->validated(), $donation->id(), auth()->id());

        if ($request->hasFile('image')) {
            if ($donation->image && Storage::disk('public')->exists($donation->image)) {
                Storage::disk('public')->delete($donation->image);
            }

            $path = $request->file('image')->store('donations', 'public');
            $donation->image = $path;
        }
        $donation->save();
        return new DonationResource($donation);
    }

    public function getByUser($id)
    {
        $donations = Donation::where('user_id', '=', $id)->get();

        if ($donations->isEmpty()) {
            return response()->json(['message' => 'donations not found'], 404);
        }

        return DonationResource::collection($donations);
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
    
    public function destroy(Donation $donation)
    {
        if (auth()->id() != $donation->user_id) {
            return response()->json(['message' => 'invalid operation, mismatched credentials'], 401);
        }

        if ($donation->image && Storage::disk('public')->exists($donation->image)) {
            Storage::disk('public')->delete($donation->image);
        }

        $donation->delete();
        return response(null, 204);
    }
}
