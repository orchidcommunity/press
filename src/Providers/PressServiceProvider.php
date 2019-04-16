<?php

declare(strict_types=1);

namespace Orchid\Press\Providers;

use Illuminate\Support\Str;
use Orchid\Press\Models\Page;
use Orchid\Press\Models\Post;
use Orchid\Platform\Dashboard;
use Orchid\Press\Entities\Many;
use Orchid\Press\Entities\Single;
use Orchid\Press\Models\Category;
use Orchid\Platform\ItemPermission;
use Illuminate\Support\Facades\View;
use Symfony\Component\Finder\Finder;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Orchid\Press\Commands\MakeManyBehavior;
use Orchid\Press\Commands\MakeSingleBehavior;
use Orchid\Press\Http\Composers\PressMenuComposer;
use Orchid\Press\Http\Composers\SystemMenuComposer;

class PressServiceProvider extends ServiceProvider
{
    /**
     * @var Dashboard
     */
    protected $dashboard;

    /**
     * The available command shortname.
     *
     * @var array
     */
    protected $commands = [
        MakeManyBehavior::class,
        MakeSingleBehavior::class,
    ];

    /**
     * Boot the application events.
     *
     * @param Dashboard $dashboard
     */
    public function boot(Dashboard $dashboard)
    {
        $this->dashboard = $dashboard;
        $this->app->booted(function () {
            $this->registerDashboardRoutes();
            $this->registerBinding();
        });

        $this->app->register(WebServiceProvider::class);

        $this->registerDatabase()
            ->registerConfig()
            ->registerViews()
            ->registerCommands();

        $this->dashboard
            ->registerEntities($this->findEntities())
            ->registerPermissions($this->registerPermissionsEntities())
            ->registerPermissions($this->registerPermissions());

        View::composer('platform::layouts.dashboard', PressMenuComposer::class);
        View::composer('platform::container.systems.index', SystemMenuComposer::class);


    }

    /**
     * Register the Press service provider.
     */
    public function register()
    {
        if (! defined('PRESS_PATH')) {
            /*
             * Get the path to the ORCHID Press folder.
             */
            define('PRESS_PATH', realpath(__DIR__.'/../../'));
        }
    }



    /**
     * Register views & Publish views.
     *
     * @return $this
     */
    public function registerViews(): self
    {
        $this->loadViewsFrom(PRESS_PATH.'/resources/views', 'press');

        $this->publishes([
            PRESS_PATH.'/resources/views' => resource_path('views/vendor/press'),
        ], 'views');

        return $this;
    }

    /**
     * Register dashboard routes.
     */
    public function registerDashboardRoutes()
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

    /**
     * Register config.
     *
     * @return $this
     */
    protected function registerConfig()
    {
        $this->publishes([
            realpath(PRESS_PATH.'/config/press.php') => config_path('press.php'),
        ], 'config');

        $this->mergeConfigFrom(
            realpath(PRESS_PATH.'/config/press.php'), 'press'
        );

        return $this;
    }

    /**
     * Register migrate.
     *
     * @return $this
     */
    protected function registerDatabase()
    {
        $this->loadMigrationsFrom(realpath(PRESS_PATH.'/database/migrations/press'));

        return $this;
    }

    /**
     * @return array
     */
    public function findEntities(): array
    {
        $namespace = app()->getNamespace();
        $directory = app_path('Orchid/Entities');
        $resources = [];

        if (! is_dir($directory)) {
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

    /**
     * @return ItemPermission
     */
    protected function registerPermissionsEntities(): ItemPermission
    {
        $permissions = new ItemPermission();

        $posts = $this->dashboard
            ->getEntities()
            ->each(function ($post) use ($permissions) {
                $permissions->addPermission('platform.entities.type.'.$post->slug, $post->name);
            });

        if ($posts->count() > 0) {
            $permissions->group = __('Posts');
        }

        return $permissions;
    }

    /**
     * @return ItemPermission
     */
    protected function registerPermissions(): ItemPermission
    {
        return ItemPermission::group(__('Systems'))
            ->addPermission('platform.systems.menu', __('Menu'));
    }

    /**
     * Route binding.
     *
     * @return $this
     */
    public function registerBinding()
    {
        Route::bind('category', function ($value) {
            $category = Dashboard::modelClass(Category::class);

            return is_numeric($value)
                ? $category->where('id', $value)->firstOrFail()
                : $category->firstOrFail($value);
        });

        Route::bind('type', function ($value) {
            $post = Dashboard::modelClass(Post::class);

            return $post->getEntity($value)->getEntityObject();
        });

        Route::bind('page', function ($value) {
            $model = Dashboard::modelClass(Page::class);

            $page = is_numeric($value)
                ? $model->where('id', $value)->first()
                : $model->where('slug', $value)->first();

            if (is_null($page)) {
                $model->slug = $value;
                $page = $model;
            }

            return $page;
        });

        Route::bind('post', function ($value) {
            $post = Dashboard::modelClass(Post::class);

            return is_numeric($value)
                ? $post->where('id', $value)->firstOrFail()
                : $post->where('slug', $value)->firstOrFail();
        });

        return $this;
    }

    /**
     * Register console commands.
     *
     * @return void
     */
    public function registerCommands()
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        foreach ($this->commands as $command) {
            $this->commands($command);
        }
    }

}
