<?php

use Illuminate\Support\Facades\Route;
use App\Services\WindowsVM\Http\Controllers\WindowsVMAdminController;

/*
|--------------------------------------------------------------------------
| WindowsVM - Admin Routes
|--------------------------------------------------------------------------
| We purposely register a route for /admin/orders/{order}/edit-service so
| the "Service" tab in the admin order page shows our custom interface.
|
| NOTE: WemX has a default route for this URI. If both exist, whichever is
| registered first will be used. In practice, Laravel Modules routes are
| loaded early enough for this to work on most installs.
*/

Route::get('orders/{order}/edit-service', [WindowsVMAdminController::class, 'edit'])
    ->name('orders.edit-service');

Route::post('orders/{order}/edit-service', [WindowsVMAdminController::class, 'save'])
    ->name('windowsvm.admin.orders.edit-service.save');

// Optional: dedicated URL you can link to later if you ever want.
Route::get('windowsvm/orders/{order}/access', [WindowsVMAdminController::class, 'edit'])
    ->name('windowsvm.admin.orders.access');
