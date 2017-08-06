<?php

namespace Orchid\CMS\Http\Controllers\Systems;

use Illuminate\Support\Facades\Storage;
use Orchid\Platform\Http\Controllers\Controller;

class DefenderController extends Controller
{
    /**
     * DefenderController constructor.
     */
    public function __construct()
    {
        $this->checkPermission('dashboard.systems.defender');
    }

    /**
     * @return string
     */
    public function index()
    {
        $defenderList = Storage::allFiles('defender');
        $list = array_pop($defenderList);
        $list = $list ? json_decode(Storage::get($list)) : [];

        return view('cms::container.systems.defender.index', [
            'list' => $list,
        ]);
    }
}
