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


        $this->dashboard
            ->addPublicDirectory('press',PRESS_PATH.'/public/');

        $this->registerDirectives();
        $this->registerTranslations();

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


    /**
     * Register translations.
     *
     * @return $this
     */
    public function registerTranslations(): self
    {
        $this->loadJsonTranslationsFrom(realpath(PRESS_PATH.'/resources/lang/'));

        return $this;
    }


    }
