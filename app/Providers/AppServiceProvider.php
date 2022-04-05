<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\App;

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
        Schema::defaultStringLength(191);
        Validator::excludeUnvalidatedArrayKeys();
        
        Password::defaults(function () {
            $productionRule = Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols();

            $developmentRule = Password::min(6);

            return App::isProduction() ? $productionRule : $developmentRule;
        });
    }
}
