<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */

    public function boot()
    {
        Gate::define('admin', function ($user,$group) {
            return  $user->id == $group->admin->id;
        });
        Blade::if('admin', function ($group) {
            return request()->user()->can('admin', $group);
        });
        Blade::if('elseadmin', function ($group) {
            return !request()->user()->can('admin', $group);
        });
        Model::unguard();
    }
}
