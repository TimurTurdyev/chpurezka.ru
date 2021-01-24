<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use TCG\Voyager\Facades\Voyager as VoyagerFacade;
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
        VoyagerFacade::addFormField("App\\Admin\\FormFields\\JsonTableFieldHandler");
        VoyagerFacade::addFormField("App\\Admin\\FormFields\\JsonKeyValueFieldHandler");
    }
}
