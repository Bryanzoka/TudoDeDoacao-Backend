<?php

namespace App\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VerificationCodeModel extends Model
{
    use HasFactory;

    protected $table = 'verification_codes';

    protected $primaryKey = 'email'; 
    
    public $incrementing = false; 
    
    protected $keyType = 'string'; 

    protected $fillable = [
        'email',
        'code',
        'expires_at'
    ];
}
