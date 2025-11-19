<?php 

namespace app\Infrastructure\Services;

use app\Application\Contracts\IDonationService;
use App\Domain\Repositories\IDonationRepository;
use App\Http\Resources\DonationResource;
use App\Http\Resources\UserResource;
use App\Domain\Models\Donation;
use Illuminate\Support\Facades\Storage;
use Str;
use Exception;

class DonationService implements IDonationService
{

      private readonly IDonationRepository $donationRepository;

    public function __construct(IDonationRepository $donationRepository)
    {
        $this->donationRepository = $donationRepository;
    }

    public function getAll()
    {
        return UserResource::collection($this->donationRepository->getAll() ?? throw new Exception('donations not found', 404));
    }

    public function create(array $data)
    {
        $data['user_id'] = auth()->id();
        $data['brief_description'] = str_split($data['description'], 40)[0] . '...';

        if (isset($data['image'])) {
            $data['image'] = $data['image']->store('donations', 'public');
        }

        $data['search_name'] = strtolower(str::ascii($data['name']));
        
        return new DonationResource($this->donationRepository->create(Donation::create($data)));
    }

    public function update(array $data, int $id, int $tokenId)
    {
        $donation = $this->getDonationModelById($id);

        if (auth()->id() != $donation->user_id) {
            return response()->json(['message' => 'invalid operation, mismatched credentials'], 401);
        }

        if ($data['name']) {
            $donation->search_name = strtolower(str::ascii($data['name']));
        }

        if ($data['description']) {
            $donation->brief_description = str_split($data['description'], 40)[0] . '...';
        }

        if (isset($data['image'])) {
            if ($donation->image && Storage::disk('public')->exists($donation->image)) {
                Storage::disk('public')->delete($donation->image);
            }
            
            $donation->image = $data['image']->store('donations', 'public');
        }

        return new DonationResource($this->donationRepository->update($donation));

    }

    public function delete()
    {
        
    }

    private function getDonationModelById(int $id)
    {
        return $this->donationRepository->getById($id) ?? throw new Exception('donation not found', 404);
    }
}