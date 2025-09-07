<?php

namespace App\Domain\Repositories;

interface IUserRepository
{
    public function getAllUsers();
    public function create(array $data);
    public function getById(int $id);
}