<?php

namespace Orchid\CMS\Http\Controllers\Install;

use Orchid\Platform\Http\Controllers\Controller;
use Orchid\CMS\Http\Controllers\Install\Helpers\InstalledFileManager;

class FinalController extends Controller
{
    /**
     * Update installed file and display finished view.
     *
     * @param InstalledFileManager $fileManager
     *
     * @return \Illuminate\View\View
     */
    public function finish(InstalledFileManager $fileManager)
    {
        $fileManager->update();

        return redirect()->to('/dashboard');
    }
}
