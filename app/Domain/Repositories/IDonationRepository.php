<?php

namespace App\Domain\Repositories;

interface IDonationRepository
{
    public function findAll();
    public function save(array $data);
    public function findById();
    public function remove();
}