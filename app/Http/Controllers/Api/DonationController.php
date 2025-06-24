<?php

namespace App\Http\Controllers\Api;
use App\Enums\DonationStatus;
use App\Models\Donation;
use App\Http\Controllers\Controller;
use App\Http\Requests\DonationRequests\DonationRequest;
use App\Http\Requests\DonationRequests\DonationUpdateRequest;
use App\Http\Resources\DonationResource;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\str;

class DonationController extends Controller
{
    public function index()
    {
        $donations = Donation::all();
        return DonationResource::collection($donations);
    }

    public function store(DonationRequest $request)
    {
        $data = $request->validated();

        $data['user_id'] = auth()->id();

        if ($request->hasFile('donation_image')) {
            $data['donation_image'] = $request->file('donation_image')->store('donations', 'public');
        }

        $donation = Donation::create($data);
        $donation->donation_filteredName = strtolower(str::ascii($donation->donation_name));
        $donation->save();
        return new DonationResource($donation);
    }

    public function show(Donation $donation)
    {
        return new DonationResource($donation);
    }

    public function update(DonationUpdateRequest $request, Donation $donation)
    {
        if (auth()->id() != $donation->user_id) {
            return response()->json(['message' => 'operação inválida, credenciais não correspondentes'], 401);
        }

        //Inserir _method = PATCH nas requisições POST de form-data para atualizar a imagem e seus outros atributos
        $validatedData = $request->validated();
        $donation->fill($validatedData);

        if ($request->hasFile('donation_image')) {
            if ($donation->donation_image && Storage::disk('public')->exists($donation->donation_image)) {
                Storage::disk('public')->delete($donation->donation_image);
            }

            $path = $request->file('donation_image')->store('donations', 'public');
            $donation->donation_image = $path;
        }

        $donation->save();

        return new DonationResource($donation);
    }

    public function getByUser($id)
    {
        $donations = Donation::where('user_id', '=', $id)->get();

        if ($donations->isEmpty()) {
            return response()->json(['message' => 'Nenhuma doação encontrada'], 404);
        }

        return DonationResource::collection($donations);
    }

    public function getByName($name)
    {
        $firstWord = explode(' ', $name)[0];
        $donations = Donation::where('donation_filteredName', 'like', '%' . strtolower($firstWord) . '%')->get();

        if ($donations->isEmpty()) {
            return response()->json(['message' => 'Nenhuma doação encontrada com este nome']);
        }

        return DonationResource::collection($donations);
    }

    public function getByCategory($category)
    {
        $donations = Donation::where('donation_category', '=', $category)->get();

        if ($donations->isEmpty()) {
            return response()->json(['message'=> 'Nenhuma doação encontrada para essa categoria'],404);
        }

        return DonationResource::collection($donations);
    }

    public function getByLocation($location)
    {
        $donations = Donation::where('donation_location', '=', $location)->get();

        if ($donations->isEmpty()) {
            return response()->json(['message'=> 'Nenhuma doação encontrada para a sua localização'],404);
        }

        return DonationResource::collection($donations);
    }

    public function getByMyLocation()
    {
        $user = auth()->user();
        $donations = Donation::where('donation_location', '=', $user->location)->where('user_id', '!=', $user->id)->get();

        if ($donations->isEmpty()) {
            return response()->json(['message'=> 'Nenhuma doação disponível na sua localização'],404);
        }

        return DonationResource::collection($donations);
    }

    public function getMyDonations()
    {
        $user = auth()->user();
        $donations = Donation::where('user_id', '=', $user->id)->get();

        if ($donations->isEmpty()) {
            return response()->json(['message' => 'Nenhuma doação encontrada'], 404);
        }

        return DonationResource::collection($donations);
    }
    
    public function destroy(Donation $donation)
    {
        if (auth()->id() != $donation->user_id) {
            return response()->json(['message' => 'operação inválida, credenciais não correspondentes'], 401);
        }

        if ($donation->donation_image && Storage::disk('public')->exists($donation->donation_image)) {
            Storage::disk('public')->delete($donation->donation_image);
        }

        $donation->delete();
        return response(null, 204);
    }
}
