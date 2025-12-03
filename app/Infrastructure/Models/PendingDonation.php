<?php

namespace App\Infrastructure\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendingDonationModel extends Model
{
    use HasFactory;

    protected $table = 'pending_donations';

    protected $fillable = [
        'user_id',
        'donation_id',
    ];

  
}
