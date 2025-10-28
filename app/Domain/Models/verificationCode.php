<?php

namespace App\Domain\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class verificationCode extends Model
{
    use HasFactory;

    protected $table = 'verification_codes';

    protected $fillable = [
        'email',
        'code',
        'expires_at'
    ];

    public static function generateCodeForEmail(string $email): array
    {
        if (!str_contains($email, '@')) {
            throw new Exception("Invalid email format", 400);
        }

        $code = rand(100000, 999999);
        $expiresAt = Carbon::now()->addMinutes(10);

        return [
            'email' => $email,
            'code' => $code,
            'expires_at' => $expiresAt
        ];
    }

    public function validateCode(string $code)
    {
        if (Carbon::now()->greaterThan($this->expires_at)) {
            throw new Exception("Verification code has expired", 401);
        }

        if ($this->code !== $code) {
            throw new Exception("Invalid verification code", 401);
        }
    }
}
