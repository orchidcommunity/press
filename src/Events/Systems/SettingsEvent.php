<?php

namespace Orchid\CMS\Events\Systems;

use Orchid\CMS\Http\Forms\Systems\Settings\SettingFormGroup;

class SettingsEvent
{
    /**
     * @var
     */
    protected $form;

    /**
     * Create a new event instance.
     * SomeEvent constructor.
     *
     * @param SettingFormGroup $form
     */
    public function __construct(SettingFormGroup $form)
    {
        $this->form = $form;
    }
}
