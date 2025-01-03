<?php

namespace App\Providers;

use App\Domain\Interfaces\Repositories\GuildRepository;
use App\Domain\Interfaces\Repositories\PlayerRepository;
use App\Domain\Interfaces\Repositories\SessionRepository;
use App\Domain\Interfaces\UuidGenerator;
use App\Infrastructure\Repositories\Guild\GuildEloquentRepository;
use App\Infrastructure\Repositories\Player\PlayerEloquentRepository;
use App\Infrastructure\Repositories\Session\SessionEloquentRepository;
use App\Infrastructure\UuidGenerator\LaravelUuidGenerator;
use App\Services\Strategies\GuildBalanceStrategy;
use App\Services\Strategies\GuildBalanceVariance;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->bind(
            UuidGenerator::class,
            LaravelUuidGenerator::class
        );

        $this->app->bind(
            PlayerRepository::class,
            PlayerEloquentRepository::class
        );

        $this->app->bind(
            SessionRepository::class,
            SessionEloquentRepository::class
        );

        $this->app->bind(
            GuildRepository::class,
            GuildEloquentRepository::class
        );

        $this->app->bind(
            GuildBalanceStrategy::class,
            GuildBalanceVariance::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
        if($this->app->environment('production')) {
            URL::forceScheme('https');
        }

    }
}
