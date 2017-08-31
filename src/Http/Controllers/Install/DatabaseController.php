<?php

namespace Orchid\CMS\Http\Controllers\Install;

use Illuminate\Support\Facades\Artisan;
use Orchid\Platform\Http\Controllers\Controller;
use Orchid\CMS\Http\Controllers\Install\Helpers\DatabaseManager;

class DatabaseController extends Controller
{
    /**
     * @var DatabaseManager
     */
    private $databaseManager;

    /**
     * @param DatabaseManager $databaseManager
     */
    public function __construct(DatabaseManager $databaseManager)
    {
        $this->databaseManager = $databaseManager;
    }

    /**
     * Migrate and seed the database.
     *
     * @return \Illuminate\View\View
     */
    public function database()
    {
        Artisan::call('notifications:table');

        $response = $this->databaseManager->migrateAndSeed();

        return redirect()->route('install::administrator')
            ->with(['message' => $response]);
    }
}
