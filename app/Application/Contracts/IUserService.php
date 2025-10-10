<?php

namespace App\Application\Contracts;

interface IUserService
{
    public function getAll();
    public function getById(int $id, int $jwtUserId);
    public function create(array $data);
    public function update(array $data, int $id, int $jwtUserId);
    public function delete(int $id, int $jwtUserId);
}