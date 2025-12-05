<?php

namespace App\Infrastructure\Repositories;

use App\Infrastructure\Models\UserModel;
use App\Domain\Repositories\IUserRepository;
use App\Domain\Entities\User;

class UserRepository implements IUserRepository
{
    public function getAll(): array
    {
        return UserModel::all()->map(fn($m) => User::restore(
            $m->id,
            $m->name,
            $m->email,
            $m->phone,
            $m->profile_image,
            $m->password,
            $m->location,
            $m->role
        ))->toArray();
    }

    public function getById(int $id): ?User
    {
        $user = UserModel::where('id', $id)->first();
        if (!$user) {
            return null;
        }

        return User::restore(
            $user->id,
            $user->name,
            $user->email,
            $user->phone,
            $user->profile_image,
            $user->password,
            $user->location,
            $user->role
        );
    }

    public function getByEmail(string $email): ?User
    {
        $user = UserModel::where('email', '=', $email)->first();

        if (!$user) {
            return null;
        }

        return User::restore(
            $user->id,
            $user->name,
            $user->email,
            $user->phone,
            $user->profile_image,
            $user->password,
            $user->location,
            $user->role
        );
    }

    public function create(User $user): int
    {
        return UserModel::create([
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'phone' => $user->getPhone(),
            'profile_image' => $user->getProfileImage(),
            'location' => $user->getLocation(),
            'password' => $user->getPassword(),
            'role' => $user->getRole()
        ])->id;
    }

    public function update(User $user): void
    {
        UserModel::where('id', '=', $user->getId())->update([
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'phone' => $user->getPhone(),
            'profile_image' => $user->getProfileImage(),
            'password' => $user->getPassword(),
            'location' => $user->getLocation(),
            'role' => $user->getRole()
        ]);
    }

    public function delete(User $user): void
    {
        UserModel::where('id', '=', $user->getId())->delete();
    }
}
