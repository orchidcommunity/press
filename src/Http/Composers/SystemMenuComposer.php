<?php

declare(strict_types=1);

namespace Orchid\Press\Http\Composers;

use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemMenu;
use Orchid\Platform\Menu;

class SystemMenuComposer
{
    /**
     * @var Dashboard
     */
    private $dashboard;

    /**
     * MenuComposer constructor.
     *
     * @param Dashboard $dashboard
     */
    public function __construct(Dashboard $dashboard)
    {
        $this->dashboard = $dashboard;
    }

    /**
     * Registering the main menu items.
     */
    public function compose()
    {
        $this->dashboard->menu
            ->add(Menu::SYSTEMS,
                ItemMenu::label(__('Content management'))
                    ->slug('CMS')
                    ->icon('icon-layers')
                    ->permission('platform.systems')
                    ->sort(1000)
            )
            /*
            ->add('CMS',
                ItemMenu::label(__('Menu'))
                    ->icon('icon-menu')
                    ->route('platform.systems.menu.index')
                    ->permission('platform.systems.menu')
                    ->show(count(config('press.menu', [])) > 0)
                    ->title(__('Editing of a custom menu (navigation) using drag & drop and localization support.'))
            )
            */
            ->add('CMS',
                ItemMenu::label(__('Categories'))
                    ->icon('icon-briefcase')
                    ->route('platform.systems.category')
                    ->permission('platform.systems.category')
                    ->sort(1000)
                    ->title(__('Sort entries into groups of posts on a given topic. This helps the user to find the necessary information on the site.'))
            )
            ->add('CMS',
                ItemMenu::label(__('Comments'))
                    ->icon('icon-bubbles')
                    ->route('platform.systems.comments')
                    ->permission('platform.systems.comments')
                    ->sort(1000)
                    ->title(__("Comments allow your website's visitors to have a discussion with you and each other."))
                    ->badge(function () {
                        return \Orchid\Press\Models\Comment::where('approved', 0)->count() ?: null;
                    })
            );
    }
}
