<?php

namespace App\Infrastructure\Repositories;

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

    public function getAllByUserId(int $userId): array
    {
        return DonationModel::where('user_id', '=', $userId)->get()->map(fn($m) => Donation::restore(                
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

    public function getById(int $id): ?Donation
    {
        $model = DonationModel::where('id', '=', $id)->first();

        if (!$model) {
            return null;
        }

        return Donation::restore(
            $model->id,
            $model->user_id,
            $model->name,
            $model->search_name,
            $model->description,
            $model->brief_description,
            $model->category,
            $model->image,
            $model->location,
            $model->status
        );
    }

    public function getByUserId(int $userId): ?Donation
    {
        $model = DonationModel::where('user_id', '=', $userId)->first();

        if (!$model) {
            return null;
        }

        return Donation::restore(
            $model->id,
            $model->user_id,
            $model->name,
            $model->search_name,
            $model->description,
            $model->brief_description,
            $model->category,
            $model->image,
            $model->location,
            $model->status
        );
    }

    public function getFiltered(?string $name, ?string $category, ?string $location, ?string $status, int $limit = 30, int $offset = 0): array
    {
        $query = DonationModel::query();

        $query->when($name, fn($q) => $q->where('search_name', 'like', '%' . $name . '%'));

        $query->when($category, fn($q) => $q->where('category', $category));

        $query->when($location, fn($q) => $q->where('location', $location));

        $query->when($status, fn($q) => $q->where('status', $status));

        $models = $query->limit($limit)->offset($offset)->get();

        return $models->map(fn($m) => Donation::restore(
            $m->id,
            $m->user_id,
            $m->name,
            $m->search_name,
            $m->description,
            $m->brief_description,
            $m->category,
            $m->image,
            $m->location,
            $m->status,
        ))->toArray();
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
        DonationModel::where('id', '=', $donation->getId())->update([
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

    public function updateStatus(int $donationId, string $status): void
    {
        DonationModel::where('id', '=', $donationId)->update([
            'status' => $status
        ]);
    }

    public function delete(Donation $donation): void
    {
        DonationModel::where('id', '=', $donation->getId())->delete();
    }
}