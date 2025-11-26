<?php

namespace App\Application\Dtos\Donations;

use Illuminate\Http\UploadedFile;

class CreateDonationDto
{
    public int $userId;
    public string $name;
    public string $description;
    public string $category;
    public ?UploadedFile $image;
    public string $location;

    private function __construct(int $userId, string $name, string $description, string $category, ?UploadedFile $image, string $location)
    {
        $this->userId = $userId;
        $this->name = $name;
        $this->description = $description;
        $this->category = $category;
        $this->image = $image;
        $this->location = $location;
    }

    public static function create(int $userId, string $name, string $description, string $category, ?UploadedFile $image, string $location)
    {
        return new self($userId, $name, $description, $category, $image, $location);
    }
}