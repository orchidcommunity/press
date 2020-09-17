<?php

namespace Orchid\Press\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Orchid\Press\Models\Category;
use Orchid\Press\Models\Post;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->binding();
        //$this->filters();

        parent::boot();
    }


    public function binding()
    {
        Route::bind('post', function ($value) {
            return Post::where('slug', $value)
                ->type('blog')
                ->with(['attachment'])
                ->firstOrFail();
        });
        /*
                Route::bind('term', function ($value) {
                    return Category::where('slug', $value)
                        ->firstOrFail();
                });
        */
    }

    public function filters()
    {
        $category = Category::with('allChildrenTerm')
         ->with('term')
         ->get()
          ->map(function ($item, $key) {
              return $item->term->slug;
          })
        ->toArray();

        Route::pattern('category', implode('|', $category));
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        /*
        if ($this->app->routesAreCached()) {
            return;
        }
        */
        if (file_exists(base_path('routes/press.php'))) {
            Route::domain((string) config('press.domain'))
                ->prefix(config('press.prefix'))
                ->as('press.')
                ->middleware(config('press.middleware.public'))
                ->group(base_path('routes/press.php'));
        }
    }
}
