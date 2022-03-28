<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {

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
        if ($this->app->environment('production')) {
            \URL::forceScheme('https');
        }

        Gate::define('admin', function ($user, $group) {
            return $user->id == $group->admin->id;
        });

        Gate::define('member', function ($user, $group) {
            foreach ($group->users()->get() as $user_in_group) {
                if ($user->id == $user_in_group->id)
                    return true;
            }
            return false;
        });


        Blade::if('admin', function ($group) {
            return request()->user()->can('admin', $group);
        });

        Blade::if('elseadmin', function ($group) {
            return !request()->user()->can('admin', $group);
        });

        Blade::if('expense_creator', function ($expense) {
            return request()->user() == $expense->user && $expense->isLatest == true && $expense->action != 3;
        });

        Gate::define('expense_creator', function ($user, $expense) {
            return $user == $expense->user && $expense->isLatest == true && $expense->action != 3;
        });

        Model::unguard();
    }
}
