<?php

namespace Orchid\Http\Forms\Tools\Category;

use Illuminate\View\View;
use Orchid\Core\Models\Category;
use Orchid\Events\Tools\CategoryEvent;
use Orchid\Forms\FormGroup;

class CategoryFormGroup extends FormGroup
{
    /**
     * @var
     */
    public $event = CategoryEvent::class;

    /**
     * Description Attributes for group.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'name'        => trans('cms::tools/category.title'),
            'description' => trans('cms::tools/category.description'),
        ];
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function main(): View
    {
        return view('cms::container.tools.category.grid', [
            'category' => Category::where('parent_id', 0)->with('allChildrenTerm')->paginate(),
        ]);
    }
}
