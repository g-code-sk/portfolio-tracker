<?php

namespace App\Providers;

use App\Domain\Finnhub\Actions\FinnhubGetCompanyProfileAction;
use App\Domain\Finnhub\Actions\FinnhubGetCurrentPriceInfoAction;
use App\Domain\Finnhub\Actions\FinnhubSearchStockAction;
use App\Domain\Finnhub\Services\FinnhubIsinSymbolResolverService;
use App\Domain\Portfolio\Policies\PortfolioPolicy;
use App\Models\Portfolio;
use App\Services\HttpClientService;
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
        $this->app->singleton(HttpClientService::class, function ($app) {
            return new HttpClientService();
        });

        $this->app->singleton(FinnhubSearchStockAction::class, function ($app) {
            return new FinnhubSearchStockAction();
        });

        $this->app->singleton(FinnhubGetCurrentPriceInfoAction::class, function ($app) {
            return new FinnhubGetCurrentPriceInfoAction();
        });

        $this->app->singleton(FinnhubGetCompanyProfileAction::class, function ($app) {
            return new FinnhubGetCompanyProfileAction();
        });

        $this->app->singleton(FinnhubIsinSymbolResolverService::class, function ($app) {
            return new FinnhubIsinSymbolResolverService();
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
