<?php

namespace Orchid\CMS\Behaviors\Storage;

use Orchid\Platform\Kernel\Storage;

class SingleBehaviorStorage extends Storage
{
    /**
     * @var string
     */
    protected $configField = 'cms.single';
}
