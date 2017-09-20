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
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Collection $attributes)
    {
        $attributes->put('slug', str_slug($attributes->get('name')));

        return view($this->view, $attributes);
    }
}
