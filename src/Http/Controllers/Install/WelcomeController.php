<?php

namespace Orchid\CMS\Http\Controllers\Install;

use Illuminate\Support\Facades\Artisan;
use Orchid\Platform\Http\Controllers\Controller;

class WelcomeController extends Controller
{
    /**
     * Display the installer welcome page.
     *
     * @return \Illuminate\View\View
     */
    public function welcome()
    {
        try {
            Artisan::call('vendor:publish', [
                '--all' => true,
                '--force' => true,
            ]);
            Artisan::call('event:generate');
            Artisan::call('config:clear');
            Artisan::call('view:clear');
            Artisan::call('route:clear');
            Artisan::call('storage:link');
            Artisan::call('notifications:table');
            Artisan::call('make:auth');
        } catch (\Exception $exception) {
            $exception = $exception->getMessage();
        }

        return view('cms::container.install.welcome', [
             'exception' => isset($exception) ? $exception : null,
        ]);
    }
}
