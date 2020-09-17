<?php

declare(strict_types=1);

namespace Orchid\Press\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Press\Commands\MakeEntityMany;
use Orchid\Press\Commands\MakeEntitySingle;
use Orchid\Press\Commands\TemplateCommand;
use Orchid\Press\Entities\Many;
use Orchid\Press\Entities\Single;
use Orchid\Press\Http\Composers\PressMenuComposer;
use Orchid\Press\Http\Composers\SystemMenuComposer;
use Symfony\Component\Finder\Finder;

/**
 * Class PressServiceProvider.
 * After update run:  php artisan vendor:publish --provider="Orchid\Press\Providers\PressServiceProvider".
 */
class PressServiceProvider extends ServiceProvider
{
    protected $dashboard;

    /**
     * Console commands.
     */
    protected $commands = [
        MakeEntityMany::class,
        MakeEntitySingle::class,
        TemplateCommand::class,
    ];

    /**
     * Boot the application events.
     *
     * @param  Dashboard  $dashboard
     */
    public function boot(Dashboard $dashboard): void
    {
        $this->dashboard = $dashboard;

        $this->app->booted(function () {
            $this->registerDashboardRoutes();
            $this->registerBindings();
            $this->dashboard
                //->registerEntities($this->findEntities())
                //->macro($this->findEntities())
                ->registerResource('entities', $this->findEntities())
                ->registerPermissions($this->registerPermissionsEntities())
                ->registerPermissions($this->registerPermissions());
        });

        $this->dashboard->addPublicDirectory('press', PRESS_PATH.'/public/');

        View::composer('platform::app', function () use ($dashboard) {
            $dashboard
                ->registerResource('scripts', orchid_mix('/js/press.js', 'press'))
                ->registerResource('stylesheets', orchid_mix('/css/press.css', 'press'));
        });

        $this->registerMigrations()
            ->registerStubs()
            ->registerConfig()
            ->registerViews()
            ->registerCommands()
            ->registerMacros()
            ->registerTranslations()
            ->registerProviders();

        View::composer('platform::dashboard', PressMenuComposer::class);
        View::composer('platform::systems', SystemMenuComposer::class);
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        /**
         * Define package path
         */
        if (!defined('PRESS_PATH')) {
            define('PRESS_PATH', dirname(__DIR__, 2));
        }
    }

    /**
     * Register views & Publish views.
     */
    public function registerViews(): self
    {
        $this->loadViewsFrom(PRESS_PATH.'/resources/views', 'press');

        $this->publishes([
            PRESS_PATH.'/resources/views' => resource_path('views/vendor/press'),
        ], 'press-views');

        return $this;
    }

    /**
     * Register dashboard routes.
     */
    public function registerDashboardRoutes(): void
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Route::domain((string) config('platform.domain'))
            ->prefix(Dashboard::prefix('/press'))
            ->as('platform.')
            ->middleware(config('platform.middleware.private'))
            ->group(realpath(PRESS_PATH.'/routes/press.php'));
    }

    protected function registerConfig(): self
    {
        $this->publishes([
            realpath(PRESS_PATH.'/config/press.php') => config_path('press.php'),
        ], 'config');

        $this->mergeConfigFrom(
            realpath(PRESS_PATH.'/config/press.php'), 'press'
        );

        return $this;
    }

    protected function registerMigrations(): self
    {
        $this->loadMigrationsFrom(PRESS_PATH.'/database/migrations/press');

        return $this;
    }

    public function findEntities(): array
    {
        $namespace = app()->getNamespace();
        $directory = app_path('Orchid/Entities');
        $resources = [];

        if (!is_dir($directory)) {
            return [];
        }

        foreach ((new Finder())->in($directory)->files() as $resource) {
            $resource = $namespace.str_replace(
                    ['/', '.php'],
                    ['\\', ''],
                    Str::after($resource->getPathname(), app_path().DIRECTORY_SEPARATOR)
                );

            if (is_subclass_of($resource, Many::class) ||
                is_subclass_of($resource, Single::class)) {
                $resources[] = $resource;
            }
        }

        return collect($resources)->sort()->all();
    }

    protected function registerPermissionsEntities(): ItemPermission
    {
        $permissions = new ItemPermission();
        /*
        $posts = collect($this->dashboard->getResource('entities'))
            ->transform(function ($value) {
                return is_object($value) ? $value : new $value();
            })
        */
        $posts = $this->dashboard->getEntities()
            ->each(function ($post) use ($permissions) {
                $permissions->addPermission('platform.entities.type.'.$post->slug, $post->name);
            });

        if ($posts->count() > 0) {
            $permissions->group = __('Posts');
        }

        return $permissions;
    }

    protected function registerPermissions(): ItemPermission
    {
        return ItemPermission::group(__('Systems'))
            ->addPermission('platform.systems.menu', __('Menu'))
            ->addPermission('platform.systems.comments', __('Comments'))
            ->addPermission('platform.systems.category', __('Category'));
    }


    public function registerBindings(): self
    {
        require PRESS_PATH.'/routes/bindings.php';

        return $this;
    }

    public function registerCommands(): self
    {
        if (!$this->app->runningInConsole()) {
            return $this;
        }

        foreach ($this->commands as $command) {
            $this->commands($command);
        }

        return $this;
    }

    public function registerTranslations(): self
    {
        $this->loadJsonTranslationsFrom(realpath(PRESS_PATH.'/resources/lang/'));

        return $this;
    }

    protected function registerStubs(): self
    {
        $this->publishes([
            PRESS_PATH.'/install-stubs/Orchid/Entities' => app_path('Orchid/Entities'),
            PRESS_PATH.'/install-stubs/Controllers' => app_path('Http/Controllers')
        ], 'press-stubs');

        return $this;
    }

    public function registerMacros(): self
    {
        require PRESS_PATH.'/src/Support/macros.php';

        return $this;
    }


    /**
     * Register provider.
     */
    public function registerProviders(): self
    {
        if (env('PRESS_WEB')) {
            $this->app->register(WebServiceProvider::class);
        }

        return $this;
    }


}
