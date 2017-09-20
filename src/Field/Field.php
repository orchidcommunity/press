<?php

namespace Orchid\CMS\Field;

use Illuminate\Support\Collection;

abstract class Field
{
    /**
     * View template show.
     *
     * @var
     */
    public $view;

    /**
     * @param Collection $attributes
     * @param boolean $firstTimeRender
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Collection $attributes, $firstTimeRender)
    {
        $attributes->put('slug', str_slug($attributes->get('name')));
        $attributes->put('firstTimeRender', $firstTimeRender);

        return view($this->view, $attributes);
    }
}
