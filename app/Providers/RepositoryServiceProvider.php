<?php

namespace App\Providers;

use App\Repositories\Contracts\IAuthRepository;
use App\Repositories\Contracts\IHomeRepository;
use App\Repositories\SQL\AuthRepository;
use App\Repositories\SQL\HomeRepository;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

        $models = $this->getModels();
        $models[] = 'Role';
        $models[] = 'Comunity';
        foreach ($models as $model) {
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
