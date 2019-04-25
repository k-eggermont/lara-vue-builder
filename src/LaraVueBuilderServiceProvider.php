<?php

namespace Keggermont\LaraVueBuilder;

use Illuminate\Support\ServiceProvider;
use Keggermont\LaraVueBuilder\App\Commands\MakeFormCommand;

class LaraVueBuilderServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/laravuebuilder.php' => config_path('laravuebuilder.php'),
        ]);

        $this->publishes([
            __DIR__.'/resources/js' => resource_path('js/vendor/laravuebuilder'),
        ]);

        $this->publishes([
            __DIR__.'/resources/js/laravuebuilder.js' => resource_path('js/laravuebuilder.js'),
        ]);

        $this->publishes([
            __DIR__.'/resources/sass' => resource_path('sass/vendor/laravuebuilder'),
        ]);


        //include __DIR__.'/routes/api.php';
        include __DIR__.'/routes/web.php';



        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeFormCommand::class,
            ]);
        }

    }
}
