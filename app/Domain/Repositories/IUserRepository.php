<?php

namespace App\Domain\Repositories;

use App\Domain\Models\User;

interface IUserRepository
{
    public function getAll();
    public function create(array $data);
    public function getById(int $id);
    public function update(User $user, array $data);
    public function delete(User $user);
}