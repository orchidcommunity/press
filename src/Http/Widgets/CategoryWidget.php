<?php

namespace Orchid\Press\Http\Widgets;

use Orchid\Press\Models\Category;


class CategoryWidget {

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
     public function handler($type = 'main'){
		 
		 $category = Category::with('allChildrenTerm')
		 ->with('term')
		 ->get();
		 
		 //dd($category);
		 
        return view(config('press.view').'widgets.category.'.$type, [
            'category'  => $category,
        ]);
     }

}
