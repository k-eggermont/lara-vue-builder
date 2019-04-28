<?php

namespace Keggermont\LaraVueBuilder;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Keggermont\LaraVueBuilder\App\Commands\MakeFormCommand;
use Keggermont\LaraVueBuilder\App\Events\LaraVueFormCreating;

class LaraVueBuilderServiceProvider extends ServiceProvider
{

    protected $listen = [
        App\Events\LaraVueFormCreating::class,
        App\Events\LaraVueFormCreated::class,
        App\Events\LaraVueFormUpdating::class,
        App\Events\LaraVueFormUpdated::class,
        App\Events\LaraVueFormDeleting::class,
        App\Events\LaraVueFormDeleted::class,
    ];
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

        Validator::extend('is_base64',function($attribute, $value, $params, $validator) {
            if(!preg_match("/base64,/iu",$value) || !preg_match("/data:/iu",$value)) { return false; }
            try {
                $b64 = base64_decode($value,true);
                if(!$b64) { return false; }
            }
            catch(\Exception $e) {
                return false;
            }
            return true;
        });

    }
}
