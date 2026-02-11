<?php

namespace App\Providers;

use App\Services\CSVImporter;
use App\Services\Interfaces\IImporter;
use App\Services\JSONImporter;
use App\Services\XMLImporter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IImporter::class, CSVImporter::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //

    }
}
