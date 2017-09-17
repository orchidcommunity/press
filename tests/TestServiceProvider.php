<?php

namespace Orchid\CMS\Tests;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class TestServiceProvider extends LaravelServiceProvider
{
    /**
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        $this->loadMigrationsFrom(
            __DIR__.'/database/migrations'
        );
    }
}
