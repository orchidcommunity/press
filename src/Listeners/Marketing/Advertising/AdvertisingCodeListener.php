<?php

namespace Orchid\CMS\Listeners\Marketing\Advertising;

use Orchid\CMS\Http\Forms\Marketing\Advertising\AdvertisingCodeForm;

class AdvertisingCodeListener
{
    /**
     * @return string
     */
    public function handle(): string
    {
        return AdvertisingCodeForm::class;
    }
}
