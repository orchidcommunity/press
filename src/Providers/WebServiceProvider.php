<?php

namespace Orchid\Press\Providers;

use Orchid\Platform\Dashboard;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;


class WebServiceProvider extends ServiceProvider
{
    /**
     * @var Dashboard
     */
    protected $dashboard;

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot(Dashboard $dashboard): void
    {
        $this->dashboard = $dashboard;

        $this->app->register(RouteServiceProvider::class);

        $this->registerViews();
        $this->registerDirectives();
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
    public function registerDirectives() {
        Blade::directive('category', function ($expression) {
            return "<?php echo (new Orchid\Press\Http\Widgets\CategoryWidget)->get($expression); ?>";
        });

        Blade::directive('menu', function ($expression) {
            return "<?php echo (new Orchid\Press\Http\Widgets\MenuWidget)->get($expression); ?>";
        });
    }

}
