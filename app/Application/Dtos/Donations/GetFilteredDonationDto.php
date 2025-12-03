<?php

namespace App\Application\Dtos\Donations;

class GetFilteredDonationDto
{
    public ?string $name;
    public ?string $category;
    public ?string $location;
    public ?string $status;
    public int $limit;
    public int $offset;

    public function __construct(?string $name, ?string $category, ?string $location, ?string $status, int $limit, int $offset)
    {
        $this->name = $name;
        $this->category = $category;
        $this->location = $location;
        $this->status = $status;
        $this->limit = $limit;
        $this->offset = $offset;
    }

    public static function create(?string $name, ?string $category, ?string $location, ?string $status, int $limit = 30, int $offset = 0)
    {
        return new self($name, $category, $location, $status, $limit, $offset);
    }
}