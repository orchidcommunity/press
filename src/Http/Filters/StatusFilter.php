<?php

namespace Orchid\CMS\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Orchid\CMS\Filters\Filter;

class StatusFilter extends Filter
{

    /**
     *
     * @var array
     */
    public $parameters = ['status'];

    /**
     * @var bool
     */
    public $display = true;

    /**
     * @var bool
     */
    public $dashboard = true;

    /**
     * @param Builder $builder
     *
     * @return Builder
     */
    public function run(Builder $builder): Builder
    {
        return $builder->status($this->request->get('status'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function display()
    {
        return view('cms::container.posts.filters.status', [
            'request'  => $this->request,
            'behavior' => $this->behavior,
        ]);
    }
}
