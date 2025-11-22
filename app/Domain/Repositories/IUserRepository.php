<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\User;


interface IUserRepository
{
    public function getAll(): array;  
    public function create(User $user): int;
    public function getById(int $id): ?User;
    public function getByEmail(string $email): ?User;
    public function update(User $user): void;
    public function delete(User $user): void;
}