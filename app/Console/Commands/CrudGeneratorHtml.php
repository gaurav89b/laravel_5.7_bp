<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CrudGeneratorHtml extends Command
{
    //https://medium.com/@devlob/laravel-crud-generators-614caddf8bea
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud:generator_view
    {name : Class (singular) for example User}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create CRUD operations with view e.g usage php artisan crud:generator_view Material';

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
        $name = $this->argument('name');
        $this->controller($name);
        $this->model($name);
        //$this->request($name);
        $this->view($name);
        $this->lang($name);

        File::append(base_path('routes/web.php'), 'Route::resource(\'' . str_plural(strtolower($name)) . "', 'Admin\'$name.Controller');");
    }
    
    protected function getStub($type)
    {
        return file_get_contents(resource_path("stubs/$type.stub"));
    }
    
    protected function model($name)
    {
        $modelTemplate = str_replace(
            ['{{modelName}}'],
            [$name],
            $this->getStub('mvc/Model')
        );

        file_put_contents(app_path("/{$name}.php"), $modelTemplate);
    }
    
    protected function controller($name)
    {
        $controllerTemplate = str_replace(
            [
                '{{modelName}}',
                '{{modelNamePluralLowerCase}}',
                '{{modelNameSingularLowerCase}}'
            ],
            [
                $name,
                strtolower(str_plural($name)),
                strtolower($name)
            ],
            $this->getStub('mvc/Controller')
        );

        file_put_contents(app_path("/Http/Controllers/Admin/{$name}Controller.php"), $controllerTemplate);
    }

    /*protected function request($name)
    {
        $requestTemplate = str_replace(
            ['{{modelName}}'],
            [$name],
            $this->getStub('Request')
        );

        if(!file_exists($path = app_path('/Http/Requests')))
            mkdir($path, 0777, true);

        file_put_contents(app_path("/Http/Requests/{$name}Request.php"), $requestTemplate);
    }*/
    
    protected function view($name)
    {
        $pluralName = strtolower(str_plural($name));
        $singularName = strtolower($name);
        if(!file_exists($path = app_path("../resources/views/admin/{$singularName}"))) {
            mkdir($path, 0777, true);
        }
        
        $aFileName = ['create', 'edit', 'index'];
        foreach ($aFileName as $fileName) {
            $modelTemplate = str_replace(
                [
                    '{{modelName}}',
                    '{{modelNamePlural}}',
                    '{{modelNamePluralLowerCase}}',
                    '{{modelNameSingularLowerCase}}'
                ],
                [
                    $name,
                    str_plural($name),
                    strtolower(str_plural($name)),
                    strtolower($name)
                ],
                $this->getStub("view/$fileName")
            );

            file_put_contents(app_path("../resources/views/admin/{$singularName}/$fileName.blade.php"), $modelTemplate);
        }
        
    }
    
    protected function lang($name) {
        $pluralLowerName = strtolower(str_plural($name));
        $singularLowerName = strtolower($name);
        $modelTemplate = str_replace(
            [
                '{{modelName}}',
                '{{modelNamePlural}}',
                '{{modelNamePluralLowerCase}}',
                '{{modelNameSingularLowerCase}}'
            ],
            [
                $name,
                str_plural($name),
                strtolower(str_plural($name)),
                strtolower($name)
            ],
            $this->getStub("mvc/lang")
        );

        file_put_contents(app_path("../resources/lang/en/admin/$pluralLowerName.php"), $modelTemplate);
    }
}
