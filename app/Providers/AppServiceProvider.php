<?php

namespace App\Providers;

use App\Application\Contracts\IEmailService;
use App\Domain\Repositories\IDonationRepository;
use App\Domain\Repositories\IRefreshTokenRepository;
use App\Domain\Repositories\IVerificationCodeRepository;
use app\Infrastructure\Repositories\DonationRepository;
use App\Infrastructure\Repositories\RefreshTokenRepository;
use App\Infrastructure\Repositories\VerificationCodeRepository;
use App\Infrastructure\Services\EmailService;
use App\Domain\Repositories\IUserRepository;
use App\Infrastructure\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IUserRepository::class, UserRepository::class);
        $this->app->bind(IRefreshTokenRepository::class, RefreshTokenRepository::class);
        $this->app->bind(IEmailService::class, EmailService::class);
        $this->app->bind(IVerificationCodeRepository::class, VerificationCodeRepository::class);
        $this->app->bind(IDonationRepository::class, DonationRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
