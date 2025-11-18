<?php

namespace App\Providers;

use App\Domain\Finnhub\Actions\FinnhubSearchStockAction;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(FinnhubSearchStockAction::class, function ($app) {
            $apiToken = config('services.finnhub.token');

            if (empty($apiToken)) {
                throw new \RuntimeException('FINNHUB_API_TOKEN is not set in .env file');
            }

            return new FinnhubSearchStockAction($apiToken);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
