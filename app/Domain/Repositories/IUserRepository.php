<?php

namespace App\Domain\Repositories;

use App\Domain\Models\User;

interface IUserRepository
{
    public function getAll();
    public function create(User $user);
    public function getById(int $id);
    public function getByEmail(string $email);
    public function update(User $user);
    public function delete(User $user);
}