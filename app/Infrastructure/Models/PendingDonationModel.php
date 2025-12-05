<?php

namespace App\Infrastructure\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PendingDonationModel extends Model
{
    use HasFactory;

    protected $table = 'pending_donations';

    protected $fillable = [
        'user_id',
        'donation_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(UserModel::class, 'user_id');
    }

    public function donation(): BelongsTo
    {
        return $this->belongsTo(DonationModel::class, 'donation_id');
    }
}
