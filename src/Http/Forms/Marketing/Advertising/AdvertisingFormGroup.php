<?php

namespace Orchid\CMS\Http\Forms\Marketing\Advertising;

use Illuminate\Contracts\View\View;
use Orchid\CMS\Core\Models\Post;
use Orchid\CMS\Events\Marketing\AdvertisingEvent;
use Orchid\Platform\Forms\FormGroup;

class AdvertisingFormGroup extends FormGroup
{
    /**
     * @var
     */
    public $event = AdvertisingEvent::class;

    /**
     * Description Attributes for group.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'name'        => trans('cms::marketing/advertising.title'),
            'description' => trans('cms::marketing/advertising.description'),
        ];
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|View|\Illuminate\View\View
     */
    public function main(): View
    {
        return view('cms::container.marketing.advertising.grid', [
            'ads' => Post::type('advertising')->paginate(),
        ]);
    }
}
