<?php

namespace App\Infrastructure\Models;

use App\Infrastructure\Models\UserModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationModel extends Model
{
    use HasFactory;

    protected $table = 'donations';

    protected $fillable = [
        'user_id',
        'name',
        'search_name',
        'description',
        'brief_description',
        'category',
        'image',
        'location',
        'status',
    ];

    public function favoritedByUsers()
    {
        return $this->belongsToMany(UserModel::class, 'favorites')->withTimestamps();
    }
}
