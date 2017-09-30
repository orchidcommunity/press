<?php

namespace Orchid\CMS\Listeners\Systems\Settings;

use Orchid\CMS\Http\Forms\Systems\Settings\BaseSettingsForm;

class SettingBaseListener
{
    /**
     * Handle the event.
     *
     * @return string
     *
     * @internal param SettingsEvent $event
     */
    public function handle() : string
    {
        return BaseSettingsForm::class;
    }
}
