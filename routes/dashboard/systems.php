<?php

/*
|--------------------------------------------------------------------------
| Systems Web Routes
|--------------------------------------------------------------------------
|
| Base route
|
*/

$this->group([
    'middleware' => ['web', 'dashboard', 'access'],
    'prefix'     => 'dashboard/systems',
    'namespace'  => 'Orchid\CMS\Http\Controllers\Systems',
],
    function (\Illuminate\Routing\Router $router) {
        $router->get('settings', [
            'as'   => 'dashboard.systems.settings',
            'uses' => 'SettingController@index',
        ]);

        $router->post('settings', [
            'as'   => 'dashboard.systems.settings',
            'uses' => 'SettingController@store',
        ]);

        $router->resource('backup', 'BackupController', ['names' => [
            'index' => 'dashboard.systems.backup',
            'show'  => 'dashboard.systems.backup.download',
        ]]);

        $router->resource('schema', 'SchemaController', ['names' => [
            'index' => 'dashboard.systems.schema.index',
            'show'  => 'dashboard.systems.schema.show',
        ]]);

        $router->resource('logs', 'LogController', ['names' => [
            'index'    => 'dashboard.systems.logs.index',
            'show'     => 'dashboard.systems.logs.show',
            'download' => 'dashboard.systems.logs.show',
            'destroy'  => 'dashboard.systems.logs.destroy',
        ]]);

        $router->resource('defender', 'DefenderController', ['names' => [
            'index' => 'dashboard.systems.defender.index',
        ]]);

        $router->get('monitor', [
            'as'   => 'dashboard.systems.monitor',
            'uses' => 'MonitorController@index',
        ]);
    });
