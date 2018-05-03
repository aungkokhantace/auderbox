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
        $this->app->bind('App\Setup\Customer\CustomerRepositoryInterface','App\Setup\Customer\CustomerRepository');
        $this->app->bind('App\Setup\Backend\BackendRepositoryInterface','App\Setup\Backend\BackendRepository');
        $this->app->bind('App\Setup\FrontEnd\FrontEndRepositoryInterface','App\Setup\FrontEnd\FrontEndRepository');
        $this->app->bind('App\Setup\BackendClient\BackendClientRepositoryInterface','App\Setup\BackendClient\BackendClientRepository');
    }
}
