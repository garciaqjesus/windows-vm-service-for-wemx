<?php

namespace App\Services\WindowsVM\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    protected string $moduleNamespace = 'App\\Services\\WindowsVM\\Http\\Controllers';

    public function map(): void
    {
        $this->mapWebRoutes();
        $this->mapAdminRoutes();
    }

    protected function mapWebRoutes(): void
    {
        Route::middleware('web')
            ->namespace($this->moduleNamespace)
            ->group(module_path('windowsvm', 'Routes/web.php'));
    }

    protected function mapAdminRoutes(): void
    {
        Route::middleware(['web', 'admin'])
            ->namespace($this->moduleNamespace)
            // Register under /admin so we can provide both WindowsVM pages
            // and a custom order "Service" tab implementation.
            ->prefix('admin')
            ->group(module_path('windowsvm', 'Routes/admin.php'));
    }
}
