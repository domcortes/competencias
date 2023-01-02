<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
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
        $this->register();

        Gate::define('organizador-menu', function ($user) {
            if($user->role =='organizador')
            {
                return true;
            } else {
                return false;
            }
        });

        Gate::define('atleta-menu', function ($user) {
            if($user->role =='atleta')
            {
                return true;
            } else {
                return false;
            }
        });
    }
}
