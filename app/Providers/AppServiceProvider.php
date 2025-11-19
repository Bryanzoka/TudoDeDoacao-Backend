<?php

namespace App\Providers;

use App\Application\Contracts\IAuthService;
use app\Application\Contracts\IDonationService;
use App\Application\Contracts\IEmailService;
use App\Application\Contracts\IUserService;
use App\Application\Contracts\IVerificationCodeService;
use App\Domain\Repositories\IDonationRepository;
use App\Domain\Repositories\IVerificationCodeRepository;
use app\Infrastructure\Repositories\DonationRepository;
use App\Infrastructure\Repositories\VerificationCodeRepository;
use App\Infrastructure\Services\AuthService;
use app\Infrastructure\Services\DonationService;
use App\Infrastructure\Services\EmailService;
use App\Infrastructure\Services\UserService;
use App\Domain\Repositories\IUserRepository;
use App\Infrastructure\Repositories\UserRepository;
use App\Infrastructure\Services\VerificationCodeService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IUserService::class, UserService::class);
        $this->app->bind(IUserRepository::class, UserRepository::class);
        $this->app->bind(IAuthService::class, AuthService::class);
        $this->app->bind(IEmailService::class, EmailService::class);
        $this->app->bind(IVerificationCodeService::class, VerificationCodeService::class);
        $this->app->bind(IVerificationCodeRepository::class, VerificationCodeRepository::class);
        $this->app->bind(IDonationService::class, DonationService::class);
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
