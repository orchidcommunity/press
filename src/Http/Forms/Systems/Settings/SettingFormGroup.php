<?php

namespace Orchid\CMS\Http\Forms\Systems\Settings;

use Orchid\CMS\Events\Systems\SettingsEvent;
use Orchid\Platform\Forms\FormGroup;

class SettingFormGroup extends FormGroup
{
    /**
     * @var string
     */
    public $view = 'cms::container.systems.settings.settings';

    /**
     * @var
     */
    public $event = SettingsEvent::class;

    /**
     * Description Attributes for group.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'name'        => trans('cms::systems/settings.Settings'),
            'description' => trans('cms::systems/settings.Global system settings'),
        ];
    }
}
