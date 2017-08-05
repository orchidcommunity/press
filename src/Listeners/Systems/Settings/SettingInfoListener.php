<?php

namespace Orchid\CMS\Listeners\Systems\Settings;

use Orchid\CMS\Http\Forms\Systems\Settings\InfoForm;

class SettingInfoListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @return string
     *
     * @internal param SettingsEvent $event
     */
    public function handle(): string
    {
        return InfoForm::class;
    }
}
