<?php

namespace App\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;
use Str;
use Carbon\Carbon;

class RefreshTokenModel extends Model
{
    protected $fillable = [
        'id',
        'user_id',
        'token',
        'expires_at'
    ];

    public static function generate(int $userId)
    {
        return self::create([
            'user_id' => $userId,
            'token' => Str::random(64),
            'expires_at' => Carbon::now()->addDays(7)
        ]);
    }

    public function refresh()
    {
        $newRefreshToken = self::create([
            'user_id' => $this->user_id,
            'token' => Str::random(64),
            'expires_at' => Carbon::now()->addDays(7)
        ]);

        $this->delete();

        return $newRefreshToken;
    }

    public function user()
    {
        return $this->belongsTo(UserModel::class);
    }
}
