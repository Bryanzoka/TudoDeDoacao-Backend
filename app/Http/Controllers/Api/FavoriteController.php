<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DonationResource;
use Illuminate\Http\Request;
use App\Models\Donation;

class FavoriteController extends Controller
{
    public function favorite(Donation $donation)
    {
        $user = auth()->user();

        if ($user->favoriteDonations()->where('donation_id', $donation->id)->exists()) {
            return response()->json(['message' => 'donation already assigned to favorites'], 409);
        }

        $user->favoriteDonations()->attach($donation->id);

        return new DonationResource($donation);
    }

    public function unfavorite(Donation $donation)
    {
        $user = auth()->user();

        if ($user->favoriteDonations()->where('donation_id', $donation->id)->exists()) {
            $user->favoriteDonations()->detach($donation->id);
        }
        else {
            return response()->json(['message' => 'donation not assigned to your favorites', 404]);
        }

        return response()->json(null, 204);
    }

    public function myFavorites()
    {
        $user = auth()->user();

        $favorites = $user->favoriteDonations()->get();

        return DonationResource::collection($favorites);
    }
}
