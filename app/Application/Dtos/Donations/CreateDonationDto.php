<?php

namespace App\Application\Dtos\Donations;

use Illuminate\Http\UploadedFile;

class CreateDonationDto
{
    public int $userId;
<<<<<<< Updated upstream
    public int $authId;
    public string $name;
    public ?string $description;
    public ?string $category;
    public ?UploadedFile $image;
    public string $location;
=======

>>>>>>> Stashed changes

    private function __construct(int $userId, int $authId, string $name, ?string $description, ?string $category, ?UploadedFile $image, string $location)
    {
        $this->userId = $userId;
        $this->authId = $authId;
        $this->name = $name;
        $this->description = $description;
        $this->category = $category;
        $this->image = $image;
        $this->location = $location;
    }

    public static function create(int $userId, int $authId, string $name, ?string $description, ?string $category, ?UploadedFile $image, string $location)
    {
        return new self($userId, $authId, $name, $description, $category, $image, $location);
    }
}