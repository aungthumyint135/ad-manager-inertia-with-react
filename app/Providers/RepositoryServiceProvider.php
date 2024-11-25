<?php

namespace App\Providers;

use App\Foundations\BaseRepository\BaseRepository;
use App\Foundations\BaseRepository\BaseRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

        $this->app->singleton(BaseRepositoryInterface::class, BaseRepository::class);

        $models = [
            'Agency', 'Publisher','Advertiser'
        ];

        foreach ($models as $model) {
            $this->app->singleton(
                "App\Repositories\\$model\\{$model}RepositoryInterface",
                "App\Repositories\\$model\\{$model}Repository"
            );
        }
    }
}
