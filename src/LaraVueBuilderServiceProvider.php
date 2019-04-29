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


        Validator::extend('b64',function($attribute, $value, $params, $validator) {

            if(!preg_match('/^data:image\/(\w+);base64,/',$value)) { return false; }

            try {
                $b64 = base64_decode($value);
                if(!$b64) { return false;  }
            }
            catch(\Exception $e) {
                return false;
            }
            return true;
        });

        Validator::extend('uploader_not_nullable',function($attribute, $value, $params, $validator) {

            $old = 0;
            $uploaded = 0;
            if(isset($value["old"])){
                $old = sizeof($value["old"]);
            }
            if(isset($value["uploaded"])){
                $uploaded = sizeof($value["uploaded"]);
            }
            if($old+$uploaded <= 0) {
                return false;
            }
            return true;
        });

        Validator::extend('uploader_max_files',function($attribute, $value, $params, $validator) {

            $old = 0;
            $uploaded = 0;
            if(isset($value["old"])){
                $old = sizeof($value["old"]);
            }
            if(isset($value["uploaded"])){
                $uploaded = sizeof($value["uploaded"]);
            }
            if(($old+$uploaded) > $params[0]) {
                return false;
            }
            return true;
        });

        Validator::extend('b64_size',function($attribute, $value, $params, $validator) {
            try {
                $size_in_bytes = (int)(strlen(rtrim($value, '=')) * 3 / 4);
                $size_in_kb = $size_in_bytes / 1024;
                if($size_in_kb > $params[0]) { return false; }
                return true;
            } catch(\Exception $e) {
                return false;
            }
        });

//        strlen(base64_decode($encoded_data));
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
