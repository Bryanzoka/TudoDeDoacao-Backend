<?php

namespace app\Application\Contracts;

interface IDonationService
{
    public function getAll();
    public function create(array $data);
    public function update(array $data, int $id);
    public function delete();
}