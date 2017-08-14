<?php

namespace Orchid\CMS\Http\Forms\Marketing\Advertising;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;
use Orchid\CMS\Core\Models\Post;
use Orchid\Platform\Forms\Form;

class AdvertisingCodeForm extends Form
{
    /**
     * @var string
     */
    public $name = 'Code';

    /**
     * Base Model.
     *
     * @var
     */
    protected $model = Post::class;


    /**
     * AdvertisingCodeForm constructor.
     *
     * @param null $request
     */
    public function __construct($request = null)
    {
        parent::__construct($request);
        $this->name = trans('cms::marketing/advertising.code');
    }


    /**
     * @param Post $adv
     *
     * @return \Illuminate\Contracts\View\Factory|View|\Illuminate\View\View
     *
     * @internal param $item
     */
    public function get(Post $adv = null): View
    {
        if (is_null($adv)) {
            $adv = new Post();
        }

        $config = collect(config('cms'));

        return view('cms::container.marketing.advertising.code', [
            'adv'        => $adv,
            'categories' => $config->get('advertising', []),
            'language'   => App::getLocale(),
            'locales'    => $config->get('locales', []),
        ]);
    }
}
