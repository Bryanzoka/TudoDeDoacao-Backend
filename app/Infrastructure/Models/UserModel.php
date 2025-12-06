<?php

namespace App\Infrastructure\Models;

use App\Infrastructure\Models\DonationModel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Infrastructure\Models\PendingDonationModel;
use Tymon\JWTAuth\Contracts\JWTSubject;

class UserModel extends Authenticatable implements JWTSubject, MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'email',
        'phone',
        'profile_image',
        'password',
        'location',
        'role'
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function favoriteDonations()
    {
        return $this->belongsToMany(DonationModel::class, 'favorites')->withTimestamps();
    }

    public function PendingDonatinos(): HasMany
    {
        return $this->hasMany(PendingDonationModel::class, 'requester_id');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            'role' => $this->role
        ];
    }
}
