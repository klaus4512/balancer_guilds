<?php

namespace App\Providers;

use App\Domain\Interfaces\Repositories\PlayerRepository;
use App\Domain\Interfaces\UuidGenerator;
use App\Infrastructure\Repositories\Player\PlayerEloquentRepository;
use App\Infrastructure\UuidGenerator\LaravelUuidGenerator;
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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
    }
}
