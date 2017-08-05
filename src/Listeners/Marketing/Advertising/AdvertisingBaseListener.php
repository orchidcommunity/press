<?php

namespace Orchid\CMS\Listeners\Marketing\Advertising;

use Orchid\CMS\Http\Forms\Marketing\Advertising\AdvertisingMainForm;

class AdvertisingBaseListener
{
    /**
     * @return string
     */
    public function handle(): string
    {
        return AdvertisingMainForm::class;
    }
}
