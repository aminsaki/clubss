<?php

namespace holoo\modules\Payments;
use holoo\modules\Invoices\Contracts\InvoiceInterface;
use holoo\modules\Invoices\Contracts\InvoiceRepository;

use holoo\modules\Payments\Contracts\PaymentInterface;
use holoo\modules\Payments\Contracts\PaymentRepository;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    /**
     * Make config punishment optional by merging the config from the package.
     */
    public function register(): void
    {
        $this->app->bind(PaymentInterface::class , PaymentRepository::class  );
    }
    /**
     * Publishes configuration file.
     */
    public function boot(): void
    {
        $this->getMigrationsFrom();
        $this->routeRegister();
    }
    protected function routeRegister(): void
    {
        Route::prefix('api/v1')
            ->group(__DIR__ . '/routes/api.php');
    }
    protected function getMigrationsFrom(): void
    {
       $this->loadMigrationsFrom(__DIR__ . '/../databases/migrations');
    }
}
