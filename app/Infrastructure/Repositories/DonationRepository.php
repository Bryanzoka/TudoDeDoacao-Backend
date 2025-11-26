<?php

namespace app\Infrastructure\Repositories;

use App\Domain\Entities\Donation;
use App\Infrastructure\Models\DonationModel;
use App\Domain\Repositories\IDonationRepository;

class DonationRepository implements IDonationRepository
{
    public function getAll(): array
    {
        return DonationModel::all()->map(fn($m) => Donation::restore(                
            $m->id,
            $m->user_id,
            $m->name,
            $m->search_name,
            $m->description,
            $m->brief_description,
            $m->category,
            $m->image,
            $m->location,
            $m->status
        ))->toArray();
    }

    public function getById(int $id): Donation
    {
        $model = DonationModel::where('id', '=', $id)->first();
        return Donation::restore(
            $model->id,
            $model->userId,
            $model->name,
            $model->searchName,
            $model->description,
            $model->briefDescription,
            $model->category,
            $model->image,
            $model->location,
            $model->status
        );
    }

    public function create(Donation $donation): int
    {
        return DonationModel::create([
            'user_id' => $donation->getUserId(),
            'name' => $donation->getName(),
            'search_name' => $donation->getSearchName(),
            'description' => $donation->getDescription(),
            'brief_description' => $donation->getBriefDescription(),
            'category' => $donation->getCategory(),
            'image' => $donation->getImage(),
            'location' => $donation->getLocation(),
            'status' => $donation->getStatus()
        ])->id;
    }

    public function update(Donation $donation): void
    {
        DonationModel::update([
            'name' => $donation->getName(),
            'search_name' => $donation->getSearchName(),
            'description' => $donation->getDescription(),
            'brief_description' => $donation->getBriefDescription(),
            'category' => $donation->getCategory(),
            'image' => $donation->getImage(),
            'location' => $donation->getLocation(),
            'status' => $donation->getStatus()
        ]);
    }

    public function delete(Donation $donation): void
    {
        DonationModel::where('id', '=', $donation->getId())->delete();
    }
}