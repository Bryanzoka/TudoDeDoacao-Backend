<?php

namespace App\Application\Dtos\Donations;

use Illuminate\Http\UploadedFile;

class UpdateDonationDto
{
    public int $id;
    public int $authId;
    public ?string $name;
    public ?string $description;
    public ?string $category;
    public ?UploadedFile $image;
    public ?string $location;
    public ?string $status;

    private function __construct(int $id, int $authId, ?string $name, ?string $description, ?string $category, ?UploadedFile $image, ?string $location, ?string $status)
    {
        $this->id = $id;
        $this->authId = $authId;
        $this->name = $name;
        $this->description = $description;
        $this->category = $category;
        $this->image = $image;
        $this->location = $location;
        $this->status = $status;
    }

    public static function create(int $id, int $authId, ?string $name, ?string $description, ?string $category, ?UploadedFile $image, ?string $location, ?string $status)
    {
        return new self($id, $authId, $name, $description, $category, $image, $location, $status);
    }
}