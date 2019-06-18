<?php

namespace Orchid\Press\Http\Widgets;

use Orchid\Press\Models\Menu;
//use Orchid\BlogCMS\Models\Menu;

class MenuWidget {

    /**
     * @param null $arg
     *
     * @return mixed
     */
    public function get($arg = null)
    {
        return $this->handler($arg);
    }

    /**
     * @return mixed
     */
    public function handler($type = 'header')
    {
		$menu = Menu::where('lang', config('app.locale'))
            ->where('parent',0)
            ->where('type', $type)
            ->orderBy('sort','Asc')
            ->with('children')
            ->get();
        //dd($menu);

        return view(config('press.view').'widgets.menu.menu-'.$type, [
            'menu'  => $menu,
        ]);
    }

}