<?php

namespace App\Providers;

use App\Repositories\Contracts\ModelInterface;
use App\Repositories\SQL\AbstractModelInterface;
use App\Repositories\SQL\AbstractModelRepository;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

        foreach ($this->getModels() as $model) {
            $this->app->bind(
                "App\Repositories\Contracts\I{$model}Repository",
                "App\Repositories\SQL\\${model}Repository"
            );
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    protected function getModels()
    {
        $files = Storage::disk('app')->files('Models');
        return collect($files)->map(function ($file) {
            return basename($file, '.php');
        });
    }
}
