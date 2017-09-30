<?php

/*
|--------------------------------------------------------------------------
| Marketing Web Routes
|--------------------------------------------------------------------------
|
| Base route
|
*/

$this->group([
    'middleware' => ['web', 'dashboard', 'access'],
    'prefix'     => 'dashboard/marketing',
    'namespace'  => 'Orchid\CMS\Http\Controllers\Marketing',
],
    function (\Illuminate\Routing\Router $router) {
        $router->get('utm', 'UTMController@index')->name('dashboard.marketing.utm.index');

        $router->resource('robots', 'RobotsController', [
            'names' => [
                'index' => 'dashboard.marketing.robots.index',
                'store' => 'dashboard.marketing.robots.store',
            ],
        ]);
    });
