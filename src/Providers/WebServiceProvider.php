<?php

namespace Orchid\Press\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Orchid\Platform\Dashboard;

/**
 * Class WebServiceProvider.
 * After update run:  php artisan vendor:publish --provider="Orchid\Press\Providers\WebServiceProvider".
 */
class WebServiceProvider extends ServiceProvider
{
    /**
     * @var Dashboard
     */
    protected $dashboard;

    /**
     * Boot the application events.
     *
     * @param  Dashboard  $dashboard
     * @return void
     */
    public function boot(Dashboard $dashboard): void
    {
        $this->dashboard = $dashboard;

        $this->registerViews()
            ->registerRoute();
        $this->registerDirectives();

        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Register views & Publish views.
     *
     * @return $this
     */
    public function registerViews(): self
    {
        $this->loadViewsFrom(PRESS_PATH.'/resources/templates/'.config('press.theme').'/views', 'template');

        $this->publishes([
            PRESS_PATH.'/resources/templates/' => resource_path('views/vendor/press'),
        ], 'views');

        return $this;
    }

    /**
     * Register directives.
     */
    public function registerDirectives(): void
    {
        Blade::directive('category', function ($expression) {
            return "<?php echo (new Orchid\Press\Http\Widgets\CategoryWidget)->get($expression); ?>";
        });

        Blade::directive('menu', function ($expression) {
            return "<?php echo (new Orchid\Press\Http\Widgets\MenuWidget)->get($expression); ?>";
        });
    }

    /**
     * Register route.
     *
     * @return $this
     */
    protected function registerRoute(): self
    {
        $this->publishes([
            realpath(PRESS_PATH.'/install-stubs/routes/') => base_path('routes'),
        ], 'press-routes');

        return $this;
    }
}
