<?php

namespace Orchid\CMS\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Orchid\CMS\Filters\Filter;

class SearchFilter extends Filter
{

    /**
     * @var array
     */
    public $parameters = ['search'];

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
        return $builder->where('content', 'LIKE', '%' . $this->request->get('search') . '%');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function display()
    {
        return view('cms::container.posts.filters.search', [
            'request' => $this->request,
        ]);
    }
}
