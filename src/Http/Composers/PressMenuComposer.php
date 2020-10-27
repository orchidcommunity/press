<?php

declare(strict_types=1);

namespace Orchid\Press\Http\Composers;

use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemMenu;
use Orchid\Platform\Menu;
use Orchid\Press\Entities\Single;

class PressMenuComposer
{
    /**
     * @var Dashboard
     */
    private $dashboard;

    public function __construct(Dashboard $dashboard)
    {
        $this->dashboard = $dashboard;
    }

    /**
     * Registering the main menu items.
     */
    public function compose(): void
    {
        $this->registerMenuPost();
    }


    protected function registerMenuPost(): self
    {
        $this->dashboard->getEntities()
            ->where('display', true)
            ->sortBy('sort')
            ->each(function ($page) {
                $route = is_a($page, Single::class) ? 'platform.entities.type.page' : 'platform.entities.type';
                $params = is_a($page, Single::class) ? [$page->slug, $page->slug] : [$page->slug];
                $active = [route($route, $params), route($route, $params) . '/*'];

                $this->dashboard->menu->add(Menu::MAIN,
                    ItemMenu::label($page->name)
                        ->slug($page->slug)
                        ->icon($page->icon)
                        ->title($page->title)
                        ->route($route, $params)
                        ->permission('platform.entities.type.'.$page->slug)
                        ->sort($page->sort)
                        ->canSee($page->display)
                        ->active($active)
                );
            });

        return $this;
    }
}
