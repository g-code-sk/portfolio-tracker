<?php

namespace App\Providers;

use App\Domain\Finnhub\Actions\FinnhubGetQuoteAction;
use App\Domain\Finnhub\Actions\FinnhubSearchStockAction;
use App\Domain\Portfolio\Policies\PortfolioPolicy;
use App\Models\Portfolio;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Portfolio::class => PortfolioPolicy::class,
    ];

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

        $this->app->singleton(FinnhubGetQuoteAction::class, function ($app) {
            $apiToken = config('services.finnhub.token');

            if (empty($apiToken)) {
                throw new \RuntimeException('FINNHUB_API_TOKEN is not set in .env file');
            }

            return new FinnhubGetQuoteAction($apiToken);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register policies
        Gate::policy(Portfolio::class, PortfolioPolicy::class);
    }
}
