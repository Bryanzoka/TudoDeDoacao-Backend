<?php

namespace app\Application\Contracts;

interface IDonationService
{
    public function getAll();
    public function getById(int $id);
    public function create(array $data);
    public function update(array $data, int $id, int $tokenId);
    public function delete(int $id, int $tokenId);
}