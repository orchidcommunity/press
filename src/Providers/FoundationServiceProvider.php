<?php

namespace Orchid\CMS\Providers;

use Cartalyst\Tags\TagsServiceProvider;
use Illuminate\Support\ServiceProvider;
use Intervention\Image\ImageServiceProvider;
use Orchid\CMS\Behaviors\Storage\PageStorage;
use Orchid\CMS\Behaviors\Storage\PostStorage;
use Orchid\Platform\Facades\Dashboard;
use Orchid\Log\LogServiceProvider;
use Orchid\Setting\Providers\SettingServiceProvider;
use Orchid\Widget\Providers\WidgetServiceProvider;
use Spatie\Backup\BackupServiceProvider;
use Orchid\Platform\Providers\FoundationServiceProvider as PlatformServiceProvider;

class FoundationServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @param Dashboard $dashboard
     */
    public function boot(Dashboard $dashboard)
    {
        $dashboard->registerStorage('pages', new PageStorage());
        $dashboard->registerStorage('posts', new PostStorage());


        $this->registerCode();
        $this->registerDatabase();
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerPublic();

        $this->registerProviders();
    }

    /**
     * Register types.
     */
    protected function registerCode()
    {
        $this->publishes([
            CMS_PATH . '/resources/stubs/behaviors/DemoPost.stub' => app_path('/Core/Behaviors/Many/DemoPost.php'),
            CMS_PATH . '/resources/stubs/behaviors/DemoPage.stub' => app_path('/Core/Behaviors/Single/DemoPage.php'),

            CMS_PATH . '/resources/stubs/widgets/AdvertisingWidget.stub' => app_path('/Http/Widgets/AdvertisingWidget.php'),
        ]);
    }

    /**
     * Register migrate.
     */
    protected function registerDatabase()
    {
        $this->publishes([
            CMS_PATH . '/resources/stubs/database/migrations/' => database_path('migrations'),
        ], 'migrations');
    }

    /**
     * Register translations.
     */
    public function registerTranslations()
    {
        $this->loadTranslationsFrom(CMS_PATH . '/resources/lang', 'cms');
    }

    /**
     * Register config.
     */
    protected function registerConfig()
    {
        $this->publishes([
            CMS_PATH . '/resources/stubs/config/content.php' => config_path('content.php'),
        ]);

        $this->mergeConfigFrom(
            CMS_PATH . '/resources/stubs/config/content.php', 'content'
        );
    }

    /**
     * Register views.
     */
    public function registerViews()
    {
        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/vendor/orchid/dashboard';
        }, config('view.paths')), [
            CMS_PATH . '/resources/views',
        ]), 'cms');
    }

    /**
     * Register public.
     */
    protected function registerPublic()
    {
        $this->publishes([
            CMS_PATH . '/resources/assets/dist/' => public_path('orchid'),
        ], 'public');
    }


    public function registerProviders()
    {
        foreach ($this->provides() as $provide) {
            $this->app->register($provide);
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            PlatformServiceProvider::class,
            \Cviebrock\EloquentSluggable\ServiceProvider::class,
            SettingServiceProvider::class,
            WidgetServiceProvider::class,
            RouteServiceProvider::class,
            ConsoleServiceProvider::class,
            PermissionServiceProvider::class,
            EventServiceProvider::class,
            ImageServiceProvider::class,
            TagsServiceProvider::class,
            BackupServiceProvider::class,
            LogServiceProvider::class,
            MenuServiceProvider::class,
        ];
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        if (!defined('CMS_PATH')) {
            define('CMS_PATH', realpath(__DIR__ . '/../../'));
        }
    }
}
