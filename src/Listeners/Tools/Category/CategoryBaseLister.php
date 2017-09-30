<?php

namespace Orchid\CMS\Listeners\Tools\Category;

use Orchid\CMS\Http\Forms\Tools\Category\CategoryMainForm;

class CategoryBaseLister
{
    /**
     * Handle the event.
     *
     * @return mixed
     *
     * @internal param CategoryEvent $event
     */
    public function handle() : string
    {
        return CategoryMainForm::class;
    }
}
