<?php

namespace Orchid\CMS\Listeners\Tools\Category;

use Orchid\CMS\Http\Forms\Tools\Category\CategoryDescForm;

class CategoryDescLister
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @return mixed
     *
     * @internal param CategoryEvent $event
     */
    public function handle(): string
    {
        return CategoryDescForm::class;
    }
}
