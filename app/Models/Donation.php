<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $table = 'donations';

    protected $fillable = [
        'user_id',
        'donation_name',
        'donation_filteredName',
        'donation_description',
        'donation_briefDescription',
        'donation_category',
        'donation_image',
        'donation_location',
        'donation_status',
    ];
}
