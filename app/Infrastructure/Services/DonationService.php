<?php 

namespace app\Infrastructure\Services;

use app\Application\Contracts\IDonationService;
use App\Domain\Models\Donation;
use App\Domain\Repositories\IDonationRepository;
use App\Http\Resources\DonationResource;
use PhpParser\Node\Stmt\TryCatch;

class DonationService implements IDonationService
{

      private readonly IDonationRepository $donationRepository;

    public function __construct(IDonationRepository $donationRepository)
    {
        $this->donationRepository = $donationRepository;
    }

    public function getAll()
        // Donation::all(); // goes on repository
    {
        return DonationResource::collection([]);
    }

    public function create(array $data)
    {
        $data['user_id'] = auth()->id();
        $data['brief_description'] = str_split($data['description'], 40)[0] . '...';

        if ($data->hasFile('image')) {
            $data['image'] = $data->file('image')->store('donations', 'public');
        }
        
        return new DonationResource($this->donationRepository->save($data));
    }

    public function update(array $data, int $id);
    {
        
        // donation->fill($data);
    }

    public function delete()
    {

    }
}