<?php

namespace Orchid\CMS\Behaviors\Storage;

use Orchid\Platform\Kernel\Storage;

class ManyBehaviorStorage extends Storage
{
    /**
     * @var string
     */
    protected $configField = 'cms.many';
}
