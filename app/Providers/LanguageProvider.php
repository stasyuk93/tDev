<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Composers\LanguageComposer;

class LanguageProvider extends ServiceProvider
{
    public function boot()
    {

        // language switch
        View::composer('*', LanguageComposer::class);

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(LanguageComposer::class);
    }
}