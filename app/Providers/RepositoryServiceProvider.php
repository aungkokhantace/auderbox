<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Core\Role\RoleRepositoryInterface','App\Core\Role\RoleRepository');
        $this->app->bind('App\Core\Permission\PermissionRepositoryInterface','App\Core\Permission\PermissionRepository');
        $this->app->bind('App\Core\Config\ConfigRepositoryInterface','App\Core\Config\ConfigRepository');
        $this->app->bind('App\Core\User\UserRepositoryInterface','App\Core\User\UserRepository');

        // API
        $this->app->bind('App\Api\Login\LoginApiRepositoryInterface','App\Api\Login\LoginApiRepository');
        $this->app->bind('App\Api\User\UserApiRepositoryInterface','App\Api\User\UserApiRepository');
        $this->app->bind('App\Api\RetailerProfile\RetailerProfileApiRepositoryInterface','App\Api\RetailerProfile\RetailerProfileApiRepository');
        $this->app->bind('App\Api\ShopList\ShopListApiRepositoryInterface','App\Api\ShopList\ShopListApiRepository');
        $this->app->bind('App\Api\Product\ProductApiRepositoryInterface','App\Api\Product\ProductApiRepository');
        $this->app->bind('App\Api\ProductGroup\ProductGroupApiRepositoryInterface','App\Api\ProductGroup\ProductGroupApiRepository');
        $this->app->bind('App\Api\DeliveryDate\DeliveryDateApiRepositoryInterface','App\Api\DeliveryDate\DeliveryDateApiRepository');
        $this->app->bind('App\Api\Invoice\InvoiceApiRepositoryInterface','App\Api\Invoice\InvoiceApiRepository');
        $this->app->bind('App\Backend\Invoice\InvoiceRepositoryInterface','App\Backend\Invoice\InvoiceRepository');
        $this->app->bind('App\Api\Cart\CartApiRepositoryInterface','App\Api\Cart\CartApiRepository');

    }
}
