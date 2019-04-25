<?php

namespace Keggermont\LaraVueBuilder\App\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class MakeFormCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:form {name} {entity} {--policy} {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new form (VueFormBuilder)';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $force = $this->option('force');
        $policy = $this->option('policy');
        $entity = $this->argument('entity');
        $name = $this->argument('name');
        $entityClassName = explode("\\",$entity);
        $entityClassName = $entityClassName[sizeof($entityClassName)-1];
        $urlPolicy = app_path("Policies/".$entityClassName."Policy.php");


        if(file_exists(app_path("Forms/".$name.".php")) && !$force) {
            return $this->error("The form ".$name." already exists.");
        }

        if(!class_exists($entity)) {
            return $this->error("Entity ".$entity." not found.");
        }

        if($policy) {
            if(file_exists($urlPolicy) && !$force) {
                return $this->error("The policy ".$urlPolicy." already exists.");
            }
        }


        $data = file_get_contents(__DIR__."/Stubs/make-form.stub");
        $data = str_replace("{{ENTITY_PATH}}", $entity, $data);
        $data = str_replace("{{ENTITY_CLASS}}", $entityClassName, $data);
        $data = str_replace("{{NAME_FORM}}", $name, $data);
        @mkdir(app_path("Forms"));
        @unlink(app_path("Forms/".$name.".php"));
        file_put_contents(app_path("Forms/".$name.".php"), $data);

        if($policy) {
            Artisan::call('make:policy', [
                'name' => $entityClassName.'Policy', '-m' => $entityClassName
            ]);
        }

        $this->info('Your classes was generated !');

        $files = [];
        $files[] = [$name.".php", app_path("Forms/".$name.".php")];
        if($policy) {
            $files[] = [$entityClassName."Policy.php",$urlPolicy];
        }
        
        $this->table(['Name', 'Path'], $files);



/*
        dump($this->argument('name'));
        dump($this->argument('entity'));
        dump();*/
        //
    }
}
